@extends('layouts.app')

@section('title', __('track.title') . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header" style="margin-bottom: 2.5rem;">
        <div class="section-subtitle">{{ __('track.subtitle') }}</div>
        <h2>{{ __('track.title') }}</h2>
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

    <div class="auth-card" style="max-width: 560px; margin: 0 auto 3rem; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2.5rem;">
        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('track.order') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="order_id">{{ __('track.orderId') }}</label>
                <input type="number" id="order_id" name="order_id" class="form-control" required min="1" value="{{ old('order_id', $trackedOrder->id ?? '') }}" placeholder="123">
            </div>

            <div class="form-group">
                <label for="phone">{{ __('track.phone') }}</label>
                <input type="tel" id="phone" name="phone" class="form-control" required value="{{ old('phone') }}">
            </div>

            <button type="submit" class="btn-gold" style="width: 100%;">
                <i class="fas fa-search" style="margin-inline-end: 6px;"></i> {{ __('track.trackBtn') }}
            </button>
        </form>

        <p style="text-align: center; margin-top: 1.6rem; color: var(--color-text-muted); font-size: 0.85rem;">
            {{ __('track.guestHint') }}
        </p>
    </div>

    @if($trackedOrder)
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2rem 2.2rem; max-width: 860px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                <h3 style="margin: 0; color: var(--color-gold);">
                    {{ __('orders.order') }} <span style="color: var(--color-cream);">#{{ $trackedOrder->id }}</span>
                </h3>
                <div style="font-size: 0.85rem; color: var(--color-text-muted);">
                    {{ $trackedOrder->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            @include('partials.order-tracker', ['order' => $trackedOrder])

            <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
                <div>
                    @foreach($trackedOrder->items as $item)
                        <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.9rem;">
                            <span>{{ $item->quantity }} × {{ $item->item_name }}</span>
                            <strong style="color: var(--color-gold);">{{ number_format($item->unit_price * $item->quantity, 2) }} DT</strong>
                        </div>
                    @endforeach
                    <div style="display: flex; justify-content: space-between; padding-top: 1rem; font-size: 1.1rem; font-weight: 700;">
                        <span>{{ __('track.total') }}</span>
                        <span style="color: var(--color-gold);">{{ number_format($trackedOrder->total_price, 2) }} DT</span>
                    </div>
                </div>

                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.2rem; font-size: 0.9rem;">
                    <div style="margin-bottom: 0.8rem;">
                        <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ __('track.address') }}</div>
                        <div style="font-weight: 600;">{{ $trackedOrder->address }}</div>
                    </div>
                    <div style="margin-bottom: 0.8rem;">
                        <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ __('track.payment') }}</div>
                        <div style="font-weight: 600;">
                            {{ $trackedOrder->payment_method == 'flouci_card' ? __('track.paymentFlouci') : __('track.paymentCod') }}
                            <span style="display: inline-block; margin-inline-start: 6px; padding: 0.15rem 0.5rem; border-radius: 3px; font-size: 0.72rem;
                                background: {{ $trackedOrder->payment_status == 'paid' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(241, 196, 15, 0.2)' }};
                                color: {{ $trackedOrder->payment_status == 'paid' ? '#2ecc71' : '#f1c40f' }};">
                                {{ $trackedOrder->payment_status == 'paid' ? __('track.paid') : ($trackedOrder->payment_method == 'flouci_card' ? __('track.pendingPayment') : __('track.unpaid')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    @if(session('payment_success'))
    if (window.Cart) Cart.clear();
    @endif
</script>
@endsection
