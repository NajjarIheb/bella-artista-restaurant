@extends('layouts.app')

@section('title', __('orders.title') . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header" style="margin-bottom: 2.5rem;">
        <div class="section-subtitle">{{ __('auth.welcome') }}</div>
        <h2>{{ __('orders.title') }}</h2>
        <div class="divider-gold"></div>
    </div>

    @if(session('success'))
        <div class="alert-success" style="margin-bottom: 2rem;">
            <i class="fas fa-check-circle" style="margin-inline-end: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <p style="color: var(--color-text-muted); margin: 0;">{{ __('orders.subtitle') }}</p>
        <a href="{{ route('delivery') }}" class="btn-gold" style="padding: 0.6rem 1.4rem;">
            <i class="fas fa-utensils" style="margin-inline-end: 6px;"></i> {{ __('orders.orderNow') }}
        </a>
    </div>

    @forelse($orders as $order)
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.6rem 1.8rem; margin-bottom: 1.2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="font-weight: 700; font-size: 1.05rem;">
                    <span style="color: var(--color-gold);">#{{ $order->id }}</span>
                    <span style="color: var(--color-text-muted); font-weight: 400; font-size: 0.85rem;"> · {{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.3rem;">
                    {{ $order->items->sum('quantity') }} {{ __('orders.items') }}
                </div>
            </div>

            <div style="text-align: center;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.3rem;">{{ __('orders.status') }}</div>
                <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 3px; font-size: 0.8rem; font-weight: 600;
                    background: {{ $order->status == 'delivered' ? 'rgba(46, 204, 113, 0.2)' : ($order->status == 'cancelled' ? 'rgba(231, 76, 60, 0.2)' : 'rgba(241, 196, 15, 0.2)') }};
                    color: {{ $order->status == 'delivered' ? '#2ecc71' : ($order->status == 'cancelled' ? '#e74c3c' : '#f1c40f') }};">
                    {{ __('orders.status.' . $order->status) }}
                </span>
            </div>

            <div style="text-align: center;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.3rem;">{{ __('track.payment') }}</div>
                <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 3px; font-size: 0.8rem; font-weight: 600;
                    background: {{ $order->payment_status == 'paid' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(241, 196, 15, 0.2)' }};
                    color: {{ $order->payment_status == 'paid' ? '#2ecc71' : '#f1c40f' }};">
                    {{ $order->payment_status == 'paid' ? __('track.paid') : ($order->payment_method == 'flouci_card' ? __('track.pendingPayment') : __('track.unpaid')) }}
                </span>
            </div>

            <div style="text-align: center;">
                <div style="font-size: 0.78rem; color: var(--color-text-muted); margin-bottom: 0.3rem;">{{ __('track.total') }}</div>
                <strong style="color: var(--color-gold); font-size: 1.05rem;">{{ number_format($order->total_price, 2) }} DT</strong>
            </div>

            <a href="{{ route('customer.order', $order->id) }}" class="btn-gold" style="padding: 0.55rem 1.2rem; font-size: 0.85rem;">
                {{ __('orders.viewDetails') }}
            </a>
        </div>
    @empty
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 3.5rem 2rem; text-align: center;">
            <i class="fas fa-receipt text-gold" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <p style="color: var(--color-text-muted);">{{ __('orders.empty') }}</p>
            <a href="{{ route('delivery') }}" class="btn-gold" style="display: inline-block; margin-top: 1rem;">
                <i class="fas fa-utensils" style="margin-inline-end: 6px;"></i> {{ __('orders.orderNow') }}
            </a>
        </div>
    @endforelse
</div>
@endsection
