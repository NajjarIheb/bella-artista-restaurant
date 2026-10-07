@extends('layouts.admin')

@section('title', 'Manage Delivery Orders')

@section('content')
<h1 style="margin-bottom: 1rem;">Incoming Delivery Orders</h1>

<div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.2rem;">
    <a href="{{ route('admin.orders') }}" class="btn-gold" style="padding: 0.4rem 1rem; font-size: 0.85rem; background: {{ $date === now()->toDateString() ? 'var(--color-gold)' : 'transparent' }}; {{ $date === now()->toDateString() ? '' : 'border: 1px solid var(--color-gold); color: var(--color-gold);' }}">Today</a>
    <a href="{{ route('admin.orders', ['date' => now()->subDay()->toDateString(), 'status' => $status, 'q' => $search]) }}" class="btn-gold" style="padding: 0.4rem 1rem; font-size: 0.85rem; background: {{ $date === now()->subDay()->toDateString() ? 'var(--color-gold)' : 'transparent' }}; {{ $date === now()->subDay()->toDateString() ? '' : 'border: 1px solid var(--color-gold); color: var(--color-gold);' }}">Yesterday</a>
    <a href="{{ route('admin.orders', ['date' => 'all', 'status' => $status, 'q' => $search]) }}" class="btn-gold" style="padding: 0.4rem 1rem; font-size: 0.85rem; background: {{ $date === 'all' ? 'var(--color-gold)' : 'transparent' }}; {{ $date === 'all' ? '' : 'border: 1px solid var(--color-gold); color: var(--color-gold);' }}">All dates</a>
</div>

<form method="GET" action="{{ route('admin.orders') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; margin-bottom: 1.5rem; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.2rem;">
    <input type="hidden" name="date" value="{{ $date }}">
    <div style="flex: 1; min-width: 220px;">
        <label style="display: block; font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 0.4rem;">Search</label>
        <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="Customer name, phone, or order #">
    </div>
    <div>
        <label style="display: block; font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 0.4rem;">Date</label>
        <input type="date" name="date" value="{{ $date !== 'all' ? $date : '' }}" class="form-control" max="{{ now()->toDateString() }}">
    </div>
    <div>
        <label style="display: block; font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 0.4rem;">Status</label>
        <select name="status" class="form-control" style="min-width: 160px;">
            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All statuses</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="preparing" {{ $status === 'preparing' ? 'selected' : '' }}>Kitchen Preparing</option>
            <option value="out_for_delivery" {{ $status === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
            <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    <button type="submit" class="btn-gold" style="padding: 0.5rem 1.2rem;">Apply</button>
    <a href="{{ route('admin.orders') }}" class="btn-gold" style="padding: 0.5rem 1.2rem; background: transparent; border: 1px solid var(--color-border); color: var(--color-text-muted);">Reset</a>
</form>

<div style="margin-bottom: 1rem; font-size: 0.9rem; color: var(--color-text-muted);">
    Showing {{ $orders->count() }} order{{ $orders->count() === 1 ? '' : 's' }}
    @if($date !== 'all')
        for {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
    @else
        for all dates
    @endif
    @if($status !== 'all')
        with status "{{ str_replace('_', ' ', $status) }}"
    @endif
    @if(!empty($search))
        matching "{{ $search }}"
    @endif
</div>

<div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 1px solid var(--color-border); background: rgba(255,255,255,0.02);">
                <th style="padding: 1.2rem;">ID</th>
                <th style="padding: 1.2rem;">Customer</th>
                <th style="padding: 1.2rem;">Phone & Address</th>
                <th style="padding: 1.2rem;">Dishes Ordered</th>
                <th style="padding: 1.2rem;">Total</th>
                <th style="padding: 1.2rem;">Payment</th>
                <th style="padding: 1.2rem;">Status</th>
                <th style="padding: 1.2rem;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 1.2rem;">#{{ $order->id }}</td>
                <td style="padding: 1.2rem;">
                    <strong>{{ $order->customer_name }}</strong>
                </td>
                <td style="padding: 1.2rem; font-size: 0.9rem;">
                    <div><i class="fas fa-phone text-gold"></i> {{ $order->phone }}</div>
                    <div style="color: var(--color-text-muted); max-width: 250px;">{{ $order->address }}</div>
                    @if($order->notes)
                    <div style="font-style: italic; color: var(--color-gold-light); font-size: 0.8rem;">Note: {{ $order->notes }}</div>
                    @endif
                </td>
                <td style="padding: 1.2rem; font-size: 0.9rem;">
                    @foreach($order->items as $item)
                    <div>• {{ $item->quantity }}x {{ $item->item_name }} ({{ number_format($item->unit_price, 2) }} DT)</div>
                    @endforeach
                </td>
                <td style="padding: 1.2rem; font-weight: bold; color: var(--color-gold);">
                    {{ number_format($order->total_price, 2) }} DT
                    @if($order->delivery_fee !== null)
                        <div style="font-size: 0.75rem; font-weight: normal; color: var(--color-text-muted);">incl. delivery fee {{ number_format($order->delivery_fee, 2) }} DT</div>
                    @endif
                    <div style="font-size: 0.75rem; font-weight: normal; color: var(--color-text-muted);">
                        {{ $order->payment_method == 'flouci_card' ? 'FLOUCI CARD' : 'CASH ON DELIVERY' }}
                        @if($order->flouci_payment_id)
                            <div style="font-size: 0.7rem; color: #999;">ID: {{ $order->flouci_payment_id }}</div>
                        @endif
                    </div>
                </td>
                <td style="padding: 1.2rem;">
                    <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 3px; font-size: 0.8rem; font-weight: 500;
                        background: {{ $order->payment_status == 'paid' ? 'rgba(46, 204, 113, 0.2)' : ($order->payment_status == 'failed' ? 'rgba(231, 76, 60, 0.2)' : 'rgba(241, 196, 15, 0.2)') }};
                        color: {{ $order->payment_status == 'paid' ? '#2ecc71' : ($order->payment_status == 'failed' ? '#e74c3c' : '#f1c40f') }};">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                    </span>
                </td>
                <td style="padding: 1.2rem;">
                    <span style="display: inline-block; padding: 0.3rem 0.8rem; border-radius: 3px; font-size: 0.8rem; font-weight: 500;
                        background: {{ $order->status == 'delivered' ? 'rgba(46, 204, 113, 0.2)' : ($order->status == 'cancelled' ? 'rgba(231, 76, 60, 0.2)' : 'rgba(241, 196, 15, 0.2)') }};
                        color: {{ $order->status == 'delivered' ? '#2ecc71' : ($order->status == 'cancelled' ? '#e74c3c' : '#f1c40f') }};">
                        {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                    </span>
                    @if($order->status == 'cancelled' && $order->cancellation_reason)
                        <div style="font-size: 0.75rem; color: #e74c3c; margin-top: 0.4rem; max-width: 180px;">{{ $order->cancellation_reason }}</div>
                    @endif
                    @if($order->status == 'delivered' && $order->delivered_at)
                        <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 0.4rem;">{{ $order->delivered_at->format('d M H:i') }}</div>
                    @endif
                </td>
                <td style="padding: 1.2rem;">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="cancellation_reason" value="">
                        <select name="status" onchange="submitOrderStatus(this.form, this.value)" class="form-control" style="padding: 0.4rem; font-size: 0.85rem;">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Kitchen Preparing</option>
                            <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    function submitOrderStatus(form, status) {
        if (status === 'cancelled') {
            const reason = prompt('Reason for cancellation (optional):');
            form.querySelector('[name="cancellation_reason"]').value = reason || '';
        }
        form.submit();
    }
</script>
@endsection
