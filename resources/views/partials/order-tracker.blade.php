@php
    $steps = [
        'pending' => ['icon' => 'fa-clipboard-list', 'key' => 'orders.status.pending'],
        'confirmed' => ['icon' => 'fa-check-circle', 'key' => 'orders.status.confirmed'],
        'preparing' => ['icon' => 'fa-utensils', 'key' => 'orders.status.preparing'],
        'out_for_delivery' => ['icon' => 'fa-motorcycle', 'key' => 'orders.status.out_for_delivery'],
        'delivered' => ['icon' => 'fa-home', 'key' => 'orders.status.delivered'],
    ];

    $currentIndex = array_search($order->status, array_keys($steps), true);
    $isCancelled = $order->status === 'cancelled';
@endphp

@if($isCancelled)
    <div style="background: rgba(231, 76, 60, 0.12); border: 1px solid rgba(231, 76, 60, 0.35); color: #e74c3c; padding: 1rem 1.2rem; border-radius: 4px; margin-bottom: 1.5rem;">
        <i class="fas fa-times-circle" style="margin-inline-end: 8px;"></i>
        <strong>{{ __('orders.status.cancelled') }}</strong>
    </div>
@else
    <div class="order-tracker" style="display: flex; align-items: flex-start; margin-bottom: 1.5rem;">
        @foreach($steps as $status => $step)
            @php
                $idx = array_search($status, array_keys($steps), true);
                $done = $currentIndex !== false && $idx <= $currentIndex;
                $current = $currentIndex === $idx;
            @endphp
            <div class="track-step {{ $done ? 'done' : '' }} {{ $current ? 'current' : '' }}" style="min-width: 64px; text-align: center;">
                <div class="track-dot" style="width: 42px; height: 42px; margin: 0 auto 0.6rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas {{ $step['icon'] }}"></i>
                </div>
                <div style="font-size: 0.72rem; line-height: 1.35; color: var(--color-text-muted);">{{ __($step['key']) }}</div>
            </div>            @if(!$loop->last)
                <div class="track-line {{ $idx < $currentIndex ? 'done' : '' }}" style="flex: 1; height: 2px; margin-top: 20px; min-width: 12px;"></div>
            @endif
        @endforeach
    </div>
@endif
