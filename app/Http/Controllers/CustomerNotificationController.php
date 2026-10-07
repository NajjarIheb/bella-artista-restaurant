<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerNotificationController extends Controller
{
    public function index()
    {
        $notifications = CustomerNotification::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('account.notifications', compact('notifications'));
    }

    public function open(CustomerNotification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);

        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        if ($notification->order_id && Order::where('id', $notification->order_id)->where('user_id', Auth::id())->exists()) {
            return redirect()->route('customer.order', $notification->order_id);
        }

        return redirect()->route('customer.orders');
    }

    public function markAllRead()
    {
        CustomerNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back();
    }
}
