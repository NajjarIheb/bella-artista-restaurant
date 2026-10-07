<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\DeliveryZone;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'sales');
        $tabs = ['sales', 'menu', 'orders', 'reservations', 'customers', 'deals'];
        if (!in_array($tab, $tabs, true)) {
            $tab = 'sales';
        }

        $data = $this->{'build' . ucfirst($tab)}();

        return view('admin.analytics', compact('tab', 'data'));
    }

    public function storeDineIn(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
        ]);

        $itemsTotal = 0;
        $orderItems = [];

        foreach ($validated['items'] as $itemData) {
            $item = MenuItem::find($itemData['id']);
            if (!$item || $item->price === null) {
                continue;
            }
            $qty = (int) $itemData['quantity'];
            if ($qty < 1) {
                continue;
            }
            $itemsTotal += (float) $item->price * $qty;
            $orderItems[] = [
                'menu_item_id' => $item->id,
                'item_name' => $item->name,
                'unit_price' => $item->price,
                'quantity' => $qty,
                'notes' => null,
            ];
        }

        if (empty($orderItems)) {
            return back()->withErrors(['items' => 'Add at least one dish with a price.']);
        }

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'] ?: '-',
            'address' => 'Dine-in',
            'total_price' => $itemsTotal,
            'delivery_fee' => 0,
            'status' => 'delivered',
            'delivered_at' => now(),
            'order_type' => 'dine_in',
            'payment_method' => 'cash_on_delivery',
            'payment_status' => 'paid',
        ]);

        foreach ($orderItems as $orderItem) {
            $order->items()->create($orderItem);
        }

        return back()->with('success', 'Dine-in sale #' . $order->id . ' recorded (' . number_format($itemsTotal, 2) . ' DT).');
    }

    private function validOrders()
    {
        return Order::where('status', '!=', 'cancelled');
    }

    private function buildSales()
    {
        $todayStart = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        $revenueToday = (float) (clone $this->validOrders())->where('created_at', '>=', $todayStart)->sum('total_price');
        $revenueWeek = (float) (clone $this->validOrders())->where('created_at', '>=', $weekStart)->sum('total_price');
        $revenueMonth = (float) (clone $this->validOrders())->where('created_at', '>=', $monthStart)->sum('total_price');
        $revenueAll = (float) (clone $this->validOrders())->sum('total_price');

        $orderCountAll = (clone $this->validOrders())->count();
        $orderCountWeek = (clone $this->validOrders())->where('created_at', '>=', $weekStart)->count();
        $aov = $orderCountAll > 0 ? $revenueAll / $orderCountAll : 0;

        $split = $this->validOrders()
            ->selectRaw('order_type, COUNT(*) as cnt, SUM(total_price) as revenue')
            ->groupBy('order_type')
            ->get()
            ->keyBy('order_type');

        $paidSplit = Order::where('status', '!=', 'cancelled')
            ->selectRaw('payment_status, COUNT(*) as cnt, SUM(total_price) as revenue')
            ->groupBy('payment_status')
            ->get();

        $peakHours = Order::where('status', '!=', 'cancelled')
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as cnt')
            ->groupBy('hour')
            ->orderByDesc('cnt')
            ->take(8)
            ->get();

        $peakDays = Order::where('status', '!=', 'cancelled')
            ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")')
            ->get();

        $itemJoin = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled');

        $dealRevenue = (float) (clone $itemJoin)
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where('menu_items.is_deal', 1)
            ->sum(DB::raw('order_items.unit_price * order_items.quantity'));

        $regularRevenue = (float) (clone $itemJoin)
            ->leftJoin('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where(function ($q) {
                $q->where('menu_items.is_deal', 0)->orWhereNull('menu_items.is_deal');
            })
            ->sum(DB::raw('order_items.unit_price * order_items.quantity'));

        $dealOrders = (int) (clone $itemJoin)
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where('menu_items.is_deal', 1)
            ->distinct('order_items.order_id')
            ->count('order_items.order_id');

        return [
            'revenueToday' => $revenueToday,
            'revenueWeek' => $revenueWeek,
            'revenueMonth' => $revenueMonth,
            'revenueAll' => $revenueAll,
            'orderCountAll' => $orderCountAll,
            'orderCountWeek' => $orderCountWeek,
            'aov' => $aov,
            'deliveryRevenue' => (float) ($split['delivery']->revenue ?? 0),
            'dineInRevenue' => (float) ($split['dine_in']->revenue ?? 0),
            'deliveryCount' => (int) ($split['delivery']->cnt ?? 0),
            'dineInCount' => (int) ($split['dine_in']->cnt ?? 0),
            'paidSplit' => $paidSplit,
            'peakHours' => $peakHours,
            'peakDays' => $peakDays,
            'dealRevenue' => $dealRevenue,
            'regularRevenue' => $regularRevenue,
            'dealOrders' => $dealOrders,
            'menuItems' => MenuItem::orderBy('category_name')->orderBy('name')->get(),
        ];
    }

    private function buildMenu()
    {
        $bestSellers = OrderItem::select('menu_item_id', 'item_name')
            ->selectRaw('SUM(quantity) as qty, SUM(unit_price * quantity) as revenue')
            ->groupBy('menu_item_id', 'item_name')
            ->orderByDesc('qty')
            ->take(10)
            ->get();

        $soldSub = DB::table('order_items')->selectRaw('menu_item_id, SUM(quantity) as qty')->groupBy('menu_item_id');

        $menuStats = MenuItem::leftJoinSub($soldSub, 'sold', function ($join) {
            $join->on('menu_items.id', '=', 'sold.menu_item_id');
        })
            ->select('menu_items.id', 'menu_items.name', 'menu_items.category_name', 'menu_items.is_available', 'sold.qty')
            ->orderByRaw('sold.qty IS NULL, sold.qty ASC')
            ->take(20)
            ->get();

        $performance = OrderItem::join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->select('menu_items.id', 'menu_items.name', 'menu_items.price', 'menu_items.cost_price')
            ->selectRaw('SUM(order_items.quantity) as qty, SUM(order_items.unit_price * order_items.quantity) as revenue')
            ->groupBy('menu_items.id', 'menu_items.name', 'menu_items.price', 'menu_items.cost_price')
            ->get();

        $popular = $performance->sortByDesc('revenue')->take(10)->values();

        $profitable = $performance
            ->filter(function ($p) {
                return $p->cost_price !== null && $p->qty > 0;
            })
            ->map(function ($p) {
                $p->profit = (float) $p->revenue - (float) $p->cost_price * (int) $p->qty;
                return $p;
            })
            ->sortByDesc('profit')
            ->take(10)
            ->values();

        $itemsWithoutCost = MenuItem::whereNull('cost_price')->count();

        $categories = DB::table('order_items')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select('menu_items.category_name')
            ->selectRaw('SUM(order_items.quantity) as qty, SUM(order_items.unit_price * order_items.quantity) as revenue')
            ->groupBy('menu_items.category_name')
            ->orderByDesc('revenue')
            ->get();

        return [
            'bestSellers' => $bestSellers,
            'menuStats' => $menuStats,
            'popular' => $popular,
            'profitable' => $profitable,
            'itemsWithoutCost' => $itemsWithoutCost,
            'categories' => $categories,
        ];
    }

    private function buildOrders()
    {
        $ordersLast7 = Order::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as cnt')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $ordersLast4Weeks = Order::where('created_at', '>=', now()->subWeeks(3)->startOfWeek())
            ->selectRaw('YEAR(created_at) as y, WEEK(created_at) as w, COUNT(*) as cnt')
            ->groupBy('y', 'w')
            ->orderBy('y')
            ->orderBy('w')
            ->get();

        $avgMinutes = Order::whereNotNull('delivered_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, delivered_at)) as avg_min')
            ->value('avg_min');
        $avgMinutes = $avgMinutes !== null ? round((float) $avgMinutes) : null;
        $timedDeliveries = Order::whereNotNull('delivered_at')->count();

        $zoneCounts = Order::whereNotNull('delivery_zone_id')
            ->selectRaw('delivery_zone_id, COUNT(*) as cnt')
            ->groupBy('delivery_zone_id')
            ->orderByDesc('cnt')
            ->get();
        $zones = DeliveryZone::pluck('area_name', 'id');

        $cancelled = Order::where('status', 'cancelled')
            ->selectRaw('COALESCE(NULLIF(cancellation_reason, ""), "Not specified") as reason, COUNT(*) as cnt')
            ->groupBy('reason')
            ->orderByDesc('cnt')
            ->get();

        return [
            'ordersLast7' => $ordersLast7,
            'ordersLast4Weeks' => $ordersLast4Weeks,
            'avgMinutes' => $avgMinutes,
            'timedDeliveries' => $timedDeliveries,
            'zoneCounts' => $zoneCounts,
            'zones' => $zones,
            'cancelled' => $cancelled,
            'cancelledTotal' => Order::where('status', 'cancelled')->count(),
            'failedPayments' => Order::where('payment_status', 'failed')->count(),
        ];
    }

    private function buildReservations()
    {
        $reservationsLast7 = Reservation::where('date', '>=', today()->subDays(6))
            ->selectRaw('date, COUNT(*) as cnt')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $reservationsLast4Weeks = Reservation::where('date', '>=', today()->subWeeks(3)->startOfWeek())
            ->selectRaw('YEAR(date) as y, WEEK(date) as w, COUNT(*) as cnt')
            ->groupBy('y', 'w')
            ->orderBy('y')
            ->orderBy('w')
            ->get();

        $past = Reservation::where('date', '<', today())->get();
        $attended = $past->filter(function ($r) {
            return in_array($r->status, ['seated', 'completed'], true);
        })->count();
        $noShow = $past->filter(function ($r) {
            return $r->status === 'no_show';
        })->count();
        $noShowRate = ($attended + $noShow) > 0 ? round($noShow / ($attended + $noShow) * 100, 1) : null;

        $avgGuests = Reservation::avg('guests');

        $busiest = Reservation::selectRaw('HOUR(time) as hour, COUNT(*) as cnt')
            ->groupBy('hour')
            ->orderByDesc('cnt')
            ->take(6)
            ->get();

        return [
            'reservationsLast7' => $reservationsLast7,
            'reservationsLast4Weeks' => $reservationsLast4Weeks,
            'attended' => $attended,
            'noShow' => $noShow,
            'noShowRate' => $noShowRate,
            'avgGuests' => $avgGuests,
            'busiest' => $busiest,
        ];
    }

    private function buildCustomers()
    {
        $byPhone = Order::selectRaw('phone, MAX(customer_name) as customer_name, COUNT(*) as cnt')
            ->groupBy('phone')
            ->orderByDesc('cnt')
            ->get();

        $newCount = $byPhone->filter(function ($r) {
            return (int) $r->cnt === 1;
        })->count();
        $returningCount = $byPhone->count() - $newCount;

        $registeredReturning = \App\Models\User::where('role', 'customer')
            ->has('orders', '>=', 2)
            ->count();

        $ratings = Review::selectRaw("DATE_FORMAT(date, '%Y-%m') as month, AVG(rating) as avg_rating, COUNT(*) as cnt")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'byPhone' => $byPhone->take(10),
            'customerPhones' => $byPhone->count(),
            'newCount' => $newCount,
            'returningCount' => $returningCount,
            'registeredReturning' => $registeredReturning,
            'ratings' => $ratings,
            'overallRating' => Review::avg('rating'),
            'reviewCount' => Review::count(),
        ];
    }

    private function buildDeals()
    {
        $dealItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menu_items', 'order_items.menu_item_id', '=', 'menu_items.id')
            ->where('menu_items.is_deal', 1)
            ->where('orders.status', '!=', 'cancelled')
            ->select('menu_items.id', 'menu_items.name', 'menu_items.deal_group', 'menu_items.price')
            ->selectRaw('COUNT(DISTINCT order_items.order_id) as order_count, SUM(order_items.quantity) as qty, SUM(order_items.unit_price * order_items.quantity) as revenue')
            ->groupBy('menu_items.id', 'menu_items.name', 'menu_items.deal_group', 'menu_items.price')
            ->orderByDesc('order_count')
            ->get();

        $flaggedDeals = MenuItem::where('is_deal', 1)
            ->leftJoinSub(
                DB::table('order_items')->selectRaw('menu_item_id, SUM(quantity) as qty')->groupBy('menu_item_id'),
                'sold',
                function ($join) {
                    $join->on('menu_items.id', '=', 'sold.menu_item_id');
                }
            )
            ->select('menu_items.id', 'menu_items.name', 'menu_items.deal_group', 'menu_items.price', 'sold.qty')
            ->orderBy('menu_items.deal_group')
            ->orderBy('menu_items.name')
            ->get();

        $groupTotals = $dealItems->groupBy('deal_group')->map(function ($group) {
            return [
                'order_count' => $group->sum('order_count'),
                'qty' => $group->sum('qty'),
                'revenue' => (float) $group->sum('revenue'),
            ];
        });

        return [
            'dealItems' => $dealItems,
            'flaggedDeals' => $flaggedDeals,
            'groupTotals' => $groupTotals,
        ];
    }
}
