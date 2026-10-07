@extends('layouts.app')

@section('title', __('orders.order') . ' #' . $order->id . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header" style="margin-bottom: 2.5rem; text-align: start; align-items: start;">
        <a href="{{ route('customer.orders') }}" class="text-gold" style="font-size: 0.9rem; margin-bottom: 0.8rem; display: inline-block;">
            <i class="fas fa-arrow-left" style="margin-inline-end: 6px;"></i> {{ __('orders.backToOrders') }}
        </a>
        <h2 style="margin: 0;">{{ __('orders.order') }} <span style="color: var(--color-gold);">#{{ $order->id }}</span></h2>
        <div class="divider-gold"></div>
    </div>

    @if(session('payment_success'))
        <div class="alert-success" style="margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle" style="margin-inline-end: 8px;"></i> {{ __('payment.successText') }}
        </div>
    @elseif(session()->has('payment_success') && !session('payment_success'))
        <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <i class="fas fa-times-circle" style="margin-inline-end: 8px;"></i> {{ __('payment.failedText') }}
        </div>
    @elseif(session('payment_verify_error'))
        <div style="background: rgba(241, 196, 15, 0.15); border: 1px solid rgba(241, 196, 15, 0.4); color: #f1c40f; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-triangle" style="margin-inline-end: 8px;"></i> {{ __('payment.verifyFailed') }}
        </div>
    @endif

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2rem 2.2rem; margin-bottom: 1.5rem;">
        <h3 style="color: var(--color-gold); margin-bottom: 1.2rem; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">
            <i class="fas fa-truck-moving" style="margin-inline-end: 8px;"></i> {{ __('orders.tracking') }}
        </h3>
        @include('partials.order-tracker', ['order' => $order])
    </div>

    <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 1.5rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2rem 2.2rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1.2rem; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">
                <i class="fas fa-receipt" style="margin-inline-end: 8px;"></i> {{ __('orders.items') }}
            </h3>
            @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <div style="font-weight: 600;">{{ $item->item_name }}</div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">{{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} DT</div>
                    </div>
                    <strong style="color: var(--color-gold);">{{ number_format($item->unit_price * $item->quantity, 2) }} DT</strong>
                </div>
            @endforeach

            <div style="padding-top: 1rem; text-align: end;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.4rem; color: var(--color-text-muted); font-size: 0.9rem;">
                    <span>{{ __('delivery.subtotal') }}</span>
                    <span>{{ number_format($order->total_price - $order->delivery_fee, 2) }} DT</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.6rem; color: var(--color-text-muted); font-size: 0.9rem;">
                    <span>{{ __('delivery.deliveryFeeLabel') }}</span>
                    <span>{{ number_format($order->delivery_fee, 2) }} DT</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700;">
                    <span>{{ __('track.total') }}</span>
                    <span style="color: var(--color-gold);">{{ number_format($order->total_price, 2) }} DT</span>
                </div>
            </div>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2rem 2.2rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1.2rem; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">
                <i class="fas fa-info-circle" style="margin-inline-end: 8px;"></i> {{ __('orders.details') }}
            </h3>

            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.25rem;">{{ __('track.placedAt') }}</div>
                <div style="font-weight: 600;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.25rem;">{{ __('track.address') }}</div>
                <div style="font-weight: 600;">{{ $order->address }}</div>
            </div>

            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.25rem;">{{ __('track.phoneLabel') }}</div>
                <div style="font-weight: 600;">{{ $order->phone }}</div>
            </div>

            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.25rem;">{{ __('track.payment') }}</div>
                <div style="font-weight: 600;">
                    {{ $order->payment_method == 'flouci_card' ? __('track.paymentFlouci') : __('track.paymentCod') }}
                    <span style="display: inline-block; margin-inline-start: 8px; padding: 0.2rem 0.6rem; border-radius: 3px; font-size: 0.75rem; font-weight: 600;
                        background: {{ $order->payment_status == 'paid' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(241, 196, 15, 0.2)' }};
                        color: {{ $order->payment_status == 'paid' ? '#2ecc71' : '#f1c40f' }};">
                        {{ $order->payment_status == 'paid' ? __('track.paid') : ($order->payment_method == 'flouci_card' ? __('track.pendingPayment') : __('track.unpaid')) }}
                    </span>
                </div>
            </div>

            @if($order->notes)
                <div>
                    <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.25rem;">{{ __('delivery.notes') }}</div>
                    <div style="font-weight: 600; font-style: italic;">{{ $order->notes }}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @if(session('payment_success'))
    if (window.Cart) Cart.clear();
    @endif
</script>
@endsection
