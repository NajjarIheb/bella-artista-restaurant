<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\DeliveryZone;
use App\Models\RestaurantInfo;
use App\Models\Review;

class PublicController extends Controller
{
    public function index()
    {
        $info = RestaurantInfo::first();
        $featuredItems = MenuItem::where('is_available', true)->take(6)->get();
        $reviews = Review::where('approved', true)->take(3)->get();
        return view('public.index', compact('info', 'featuredItems', 'reviews'));
    }

    public function menu(Request $request)
    {
        $categories = Category::with(['menuItems' => function($q) {
            $q->where('is_available', true);
        }])->orderBy('display_order')->get();

        return view('public.menu', compact('categories'));
    }

    public function delivery()
    {
        $info = RestaurantInfo::first();
        $zones = DeliveryZone::all();
        $categories = Category::all();
        $menuItems = MenuItem::with('category')->where('is_available', true)->get();
        return view('public.delivery', compact('info', 'zones', 'categories', 'menuItems'));
    }

    public function storeDeliveryOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cash_on_delivery,flouci_card',
            'delivery_zone_id' => 'nullable|exists:delivery_zones,id',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
        ]);

        $info = RestaurantInfo::first();
        $deliveryZone = !empty($validated['delivery_zone_id']) ? DeliveryZone::find($validated['delivery_zone_id']) : null;
        $deliveryFee = $deliveryZone ? (float) $deliveryZone->delivery_fee : (float) ($info->delivery_fee ?? 0);
        $minOrder = (float) ($info->min_order_amount ?? 0);

        $itemsTotal = 0;
        $orderItemsData = [];

        foreach ($validated['items'] as $itemData) {
            $item = MenuItem::find($itemData['id']);
            if (!$item || $item->price === null) {
                continue;
            }
            $qty = (int) $itemData['quantity'];
            if ($qty < 1) {
                continue;
            }
            $lineTotal = (float) $item->price * $qty;
            $itemsTotal += $lineTotal;

            $orderItemsData[] = [
                'menu_item_id' => $item->id,
                'item_name' => $item->name,
                'unit_price' => $item->price,
                'quantity' => $qty,
                'notes' => $itemData['notes'] ?? null,
            ];
        }

        if (empty($orderItemsData)) {
            return back()->withErrors(['items' => 'Your cart is empty. Please add at least one dish.'])->withInput();
        }

        if ($itemsTotal < $minOrder) {
            return back()->withErrors(['items' => 'The minimum order amount is ' . number_format($minOrder, 2) . ' DT. Your current total is ' . number_format($itemsTotal, 2) . ' DT.'])->withInput();
        }

        $totalPrice = $itemsTotal + $deliveryFee;

        $paymentMethod = $validated['payment_method'];

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'total_price' => $totalPrice,
            'delivery_fee' => $deliveryFee,
            'delivery_zone_id' => $deliveryZone->id ?? null,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'flouci_card' ? 'pending' : 'unpaid',
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($orderItemsData as $orderItem) {
            $order->items()->create($orderItem);
        }

        if ($paymentMethod === 'flouci_card') {
            $flouci = app(\App\Services\FlouciService::class);

            if (!$flouci->isConfigured()) {
                $order->update(['payment_status' => 'failed']);

                return back()->withErrors(['payment_method' => __('payment.flouciNotConfigured')])->withInput();
            }

            $payment = $flouci->generatePayment($order);

            if (!$payment['success'] || empty($payment['link'])) {
                $order->update(['payment_status' => 'failed']);

                return back()->withErrors(['payment_method' => __('payment.redirectError')])->withInput();
            }

            $order->update([
                'flouci_payment_id' => $payment['payment_id'] ?? null,
                'payment_status' => 'pending',
            ]);

            return redirect()->away($payment['link']);
        }

        session(['track_order_id' => $order->id]);

        return redirect()->route('delivery')->with('success', __('delivery.orderPlaced', ['id' => $order->id]));
    }

    public function reservations()
    {
        $info = RestaurantInfo::first();
        return view('public.reservations', compact('info'));
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string',
        ]);

        $reservation = Reservation::create([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'guests' => $validated['guests'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('reservations')->with('success', 'Thank you! Your table reservation request for ' . $reservation->guests . ' guests on ' . $reservation->date . ' at ' . $reservation->time . ' has been received.');
    }

    public function about()
    {
        $info = RestaurantInfo::first();
        $galleryItems = MenuItem::where('is_available', true)
            ->whereNotNull('image_url')
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('public.about', compact('info', 'galleryItems'));
    }

    public function gallery()
    {
        $categories = Category::with(['menuItems' => function($q) {
            $q->where('is_available', true)->whereNotNull('image_url');
        }])->whereHas('menuItems', function($q) {
            $q->where('is_available', true)->whereNotNull('image_url');
        })->orderBy('display_order')->get();

        return view('public.gallery', compact('categories'));
    }

    public function contact()
    {
        $info = RestaurantInfo::first();
        return view('public.contact', compact('info'));
    }
}
