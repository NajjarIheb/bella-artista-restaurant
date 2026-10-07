<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\CustomerNotification;
use App\Models\RestaurantInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        $info = RestaurantInfo::first();
        return view('admin.login', compact('info'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'This area is reserved for staff. Please use the customer login.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $recentOrders = Order::with('items')->latest()->take(5)->get();
        $recentReservations = Reservation::latest()->take(5)->get();
        $totalOrders = Order::count();
        $totalReservations = Reservation::count();
        $totalMenuItems = MenuItem::count();

        return view('admin.dashboard', compact('recentOrders', 'recentReservations', 'totalOrders', 'totalReservations', 'totalMenuItems'));
    }

    public function orders(Request $request)
    {
        $query = Order::with('items');

        $date = $request->input('date', now()->toDateString());
        if (!empty($date) && $date !== 'all') {
            $query->whereDate('created_at', $date);
        }

        $status = $request->input('status', 'all');
        if ($status !== '' && $status !== 'all') {
            $query->where('status', $status);
        }

        $search = trim($request->input('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            });
        }

        $orders = $query->latest()->get();

        return view('admin.orders', compact('orders', 'date', 'status', 'search'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'cancellation_reason' => 'nullable|string|max:255',
        ]);

        $updates = ['status' => $validated['status']];
        $previousStatus = $order->status;

        if ($validated['status'] === 'delivered' && !$order->delivered_at) {
            $updates['delivered_at'] = now();
        } elseif ($validated['status'] !== 'delivered') {
            $updates['delivered_at'] = null;
        }

        if ($validated['status'] === 'cancelled') {
            $updates['cancellation_reason'] = $validated['cancellation_reason'] ?: 'Not specified';
        }

        $order->update($updates);

        if ($validated['status'] !== $previousStatus) {
            $this->notifyOrderStatus($order);
        }

        return back()->with('success', 'Order #' . $order->id . ' status updated to ' . $validated['status']);
    }

    protected function notifyOrderStatus(Order $order)
    {
        $map = [
            'confirmed' => 'orderConfirmed',
            'out_for_delivery' => 'orderOutForDelivery',
            'delivered' => 'orderDelivered',
            'cancelled' => 'orderCancelled',
        ];

        $type = $map[$order->status] ?? null;

        if (!$type) {
            return;
        }

        CustomerNotification::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'phone' => $order->user_id ? null : $order->phone,
            'type' => $type,
        ]);
    }

    public function reservations()
    {
        $reservations = Reservation::latest()->get();
        return view('admin.reservations', compact('reservations'));
    }

    public function updateReservationStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $reservation->update(['status' => $validated['status']]);
        return back()->with('success', 'Reservation #' . $reservation->id . ' status updated to ' . $validated['status']);
    }

    public function menu(Request $request)
    {
        $query = MenuItem::with('category');

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('allergens', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->filled('availability') && $request->get('availability') !== 'all') {
            $query->where('is_available', $request->get('availability') === 'available' ? 1 : 0);
        }

        $menuItems = $query->orderBy('category_id')->latest('id')->get();
        $categories = Category::all();
        return view('admin.menu', compact('menuItems', 'categories'));
    }

    public function storeMenuItem(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'image_url' => 'nullable|string',
            'allergens' => 'nullable|string',
            'is_available' => 'boolean',
            'is_deal' => 'boolean',
            'deal_group' => 'nullable|in:kids,family,other',
        ]);

        $category = Category::find($validated['category_id']);
        $validated['category_name'] = $category->name;
        $validated['is_available'] = $request->has('is_available');
        $validated['is_deal'] = $request->has('is_deal');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif (empty($validated['image_url'])) {
            unset($validated['image_url']);
        }

        MenuItem::create($validated);
        return back()->with('success', 'Menu item added successfully!');
    }

    public function updateMenuItem(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'image_url' => 'nullable|string',
            'allergens' => 'nullable|string',
            'is_deal' => 'boolean',
            'deal_group' => 'nullable|in:kids,family,other',
        ]);

        $category = Category::find($validated['category_id']);
        $validated['category_name'] = $category->name;
        $validated['is_available'] = $request->has('is_available');
        $validated['is_deal'] = $request->has('is_deal');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif (empty($validated['image_url'])) {
            unset($validated['image_url']);
        }

        $menuItem->update($validated);
        return back()->with('success', 'Menu item updated successfully!');
    }

    public function destroyMenuItem(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back()->with('success', 'Menu item removed successfully!');
    }

    public function settings()
    {
        $info = RestaurantInfo::first();
        return view('admin.settings', compact('info'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ])->withInput();
        }

        $updates = ['email' => $validated['email']];

        if (!empty($validated['password'])) {
            $updates['password'] = Hash::make($validated['password']);
        }

        $user->update($updates);

        return back()->with('success', 'Your admin account details have been updated.');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'hours' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'delivery_fee' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'delivery_radius' => 'nullable|string|max:255',
            'plus_code' => 'nullable|string|max:255',
            'maps_url' => 'nullable|string|max:500',
        ]);

        $info = RestaurantInfo::first();
        $info->update($validated);

        return back()->with('success', 'Restaurant settings updated successfully!');
    }
}
