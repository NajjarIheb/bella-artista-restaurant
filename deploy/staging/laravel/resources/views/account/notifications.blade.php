@extends('layouts.app')

@section('title', __('notif.title') . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header" style="margin-bottom: 2.5rem; align-items: start; text-align: start;">
        <a href="{{ route('customer.orders') }}" class="text-gold" style="font-size: 0.9rem; margin-bottom: 0.8rem; display: inline-block;">
            <i class="fas fa-arrow-left" style="margin-inline-end: 6px;"></i> {{ __('orders.backToOrders') }}
        </a>
        <h2 style="margin: 0;">{{ __('notif.title') }}</h2>
        <div class="divider-gold"></div>
    </div>

    @if($notifications->whereNull('read_at')->count() > 0)
        <form action="{{ route('customer.notifications.readAll') }}" method="POST" style="margin: 0 0 1.5rem; text-align: end;">
            @csrf
            <button type="submit" class="btn-gold" style="padding: 0.55rem 1.2rem; font-size: 0.85rem; background: transparent; border: 1px solid var(--color-gold); color: var(--color-gold);">
                <i class="fas fa-check-double" style="margin-inline-end: 6px;"></i> {{ __('notif.markAllRead') }}
            </button>
        </form>
    @endif

    @forelse($notifications as $notif)
        <a href="{{ route('customer.notifications.open', $notif->id) }}" style="text-decoration: none; color: inherit; display: block;">
            <div style="background: var(--bg-card); border: 1px solid {{ $notif->read_at ? 'var(--color-border)' : 'var(--color-gold)' }}; border-radius: 4px; padding: 1.4rem 1.6rem; margin-bottom: 1rem; display: flex; gap: 1rem; align-items: flex-start;">
                <div style="font-size: 1.2rem; color: var(--color-gold); flex-shrink: 0; margin-top: 0.15rem;">
                    @if($notif->type == 'orderConfirmed')
                        <i class="fas fa-check-circle"></i>
                    @elseif($notif->type == 'orderOutForDelivery')
                        <i class="fas fa-truck-moving"></i>
                    @elseif($notif->type == 'orderDelivered')
                        <i class="fas fa-check-double"></i>
                    @else
                        <i class="fas fa-times-circle"></i>
                    @endif
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: {{ $notif->read_at ? '400' : '700' }}; color: var(--color-cream);">
                        {{ __("notif." . $notif->type, ['id' => $notif->order_id]) }}
                    </div>
                    <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-top: 0.3rem;">
                        {{ $notif->created_at->diffForHumans() }}
                        @if($notif->read_at)
                            <span style="margin-inline-start: 8px;"><i class="fas fa-check"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 3.5rem 2rem; text-align: center;">
            <i class="fas fa-bell-slash text-gold" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <p style="color: var(--color-text-muted);">{{ __('notif.empty') }}</p>
        </div>
    @endforelse
</div>
@endsection
