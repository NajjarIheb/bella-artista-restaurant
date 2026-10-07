<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\FlouciService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $flouci;

    public function __construct(FlouciService $flouci)
    {
        $this->flouci = $flouci;
    }

    /**
     * Landing page reached from the Flouci checkout success/fail links.
     * Verifies the transaction, updates the order and redirects to the tracker.
     */
    public function result(Request $request, Order $order)
    {
        $paymentId = $request->query('payment_id');

        if (!$paymentId) {
            $paymentId = $order->flouci_payment_id;
        }

        if ($paymentId) {
            $verification = $this->flouci->verifyPayment($paymentId);

            if ($verification['success']) {
                if ($verification['paid']) {
                    $order->update(['payment_status' => 'paid']);
                    session()->flash('payment_success', true);
                } else {
                    $order->update(['payment_status' => 'failed']);
                    session()->flash('payment_success', false);
                }
            } else {
                session()->flash('payment_verify_error', true);
            }
        }

        return $this->redirectToTracker($order);
    }

    /**
     * Optional webhook: Flouci POSTs here with payment_id after confirmation.
     */
    public function webhook(Request $request)
    {
        $paymentId = $request->input('payment_id')
            ?? $request->query('payment_id')
            ?? $request->input('result.payment_id');

        if ($paymentId) {
            $verification = $this->flouci->verifyPayment($paymentId);

            if ($verification['success']) {
                $order = Order::where('flouci_payment_id', $paymentId)->first();

                if ($order) {
                    $order->update([
                        'payment_status' => $verification['paid'] ? 'paid' : 'failed',
                    ]);
                }

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false], 422);
    }

    protected function redirectToTracker(Order $order)
    {
        if ($order->user_id && Auth::check() && Auth::id() === $order->user_id) {
            return redirect()->route('customer.order', $order->id);
        }

        session(['track_order_id' => $order->id]);

        return redirect()->route('track.order');
    }
}
