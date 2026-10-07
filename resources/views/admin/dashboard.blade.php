@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<h1 style="margin-bottom: 2rem;">Executive Dashboard</h1>

<!-- Stats Row -->
<div class="grid-3" style="margin-bottom: 3rem;">
    <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px;">
        <h3 style="font-size: 2.5rem; color: var(--color-gold); font-family: var(--font-sans);">{{ $totalOrders }}</h3>
        <p style="margin: 0; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Total Delivery Orders</p>
    </div>

    <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px;">
        <h3 style="font-size: 2.5rem; color: var(--color-gold); font-family: var(--font-sans);">{{ $totalReservations }}</h3>
        <p style="margin: 0; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Table Reservations</p>
    </div>

    <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px;">
        <h3 style="font-size: 2.5rem; color: var(--color-gold); font-family: var(--font-sans);">{{ $totalMenuItems }}</h3>
        <p style="margin: 0; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Active Menu Items</p>
    </div>
</div>

<!-- Recent Orders & Reservations -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2.5rem;">
    <!-- Recent Orders -->
    <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px;">
        <h3 style="color: var(--color-gold); margin-bottom: 1.5rem;">Recent Orders</h3>
        @if($recentOrders->count() == 0)
            <p>No delivery orders placed yet.</p>
        @else
            @foreach($recentOrders as $order)
            <div style="padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong>#{{ $order->id }} - {{ $order->customer_name }}</strong>
                    <span style="color: var(--color-gold);">{{ number_format($order->total_price, 2) }} DT</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--color-text-muted);">
                    Status: <span style="text-transform: capitalize; color: var(--color-cream);">{{ $order->status }}</span> | {{ $order->created_at->diffForHumans() }}
                </div>
            </div>
            @endforeach
        @endif
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('admin.orders') }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8rem;">View All Orders</a>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px;">
        <h3 style="color: var(--color-gold); margin-bottom: 1.5rem;">Recent Reservations</h3>
        @if($recentReservations->count() == 0)
            <p>No reservations recorded yet.</p>
        @else
            @foreach($recentReservations as $res)
            <div style="padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong>{{ $res->customer_name }} ({{ $res->guests }} Guests)</strong>
                    <span style="font-size: 0.85rem; color: var(--color-gold);">{{ $res->date }} @ {{ $res->time }}</span>
                </div>
                <div style="font-size: 0.85rem; color: var(--color-text-muted);">
                    Phone: {{ $res->phone }} | Status: <span style="text-transform: capitalize; color: var(--color-cream);">{{ $res->status }}</span>
                </div>
            </div>
            @endforeach
        @endif
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('admin.reservations') }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8rem;">View All Reservations</a>
        </div>
    </div>
</div>
@endsection
