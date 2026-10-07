<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items')->latest()->get();

        return view('account.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items');

        return view('account.order-detail', compact('order'));
    }

    public function trackForm()
    {
        $trackedOrder = null;

        if (session()->has('track_order_id')) {
            $trackedOrder = Order::with('items')->find(session('track_order_id'));
        }

        return view('public.track-order', compact('trackedOrder'));
    }

    public function trackLookup(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer|min:1',
            'phone' => 'required|string|max:50',
        ]);

        $order = Order::with('items')->find($validated['order_id']);

        if (!$order || !$this->phoneMatches($order->phone, $validated['phone'])) {
            return back()->withErrors(['order_id' => __('track.notFound')])->withInput();
        }

        session(['track_order_id' => $order->id]);

        return redirect()->route('track.order');
    }

    protected function phoneMatches($stored, $input)
    {
        $normalize = function ($phone) {
            return preg_replace('/\D+/', '', $phone);
        };

        return $normalize($stored) === $normalize($input);
    }
}
