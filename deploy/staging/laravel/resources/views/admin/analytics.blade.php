@extends('layouts.admin')

@section('title', 'Analytics & Reports')

@section('content')
<h1 style="margin-bottom: 0.5rem;">Analytics & Reports</h1>
<p style="color: var(--color-text-muted); margin-bottom: 2rem;">Performance overview across sales, menu, delivery, reservations and customers.</p>

<!-- Tabs -->
<div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 2rem; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 0.6rem;">
    @php($tabs = ['sales' => 'Sales & Revenue', 'menu' => 'Menu Performance', 'orders' => 'Delivery Orders', 'reservations' => 'Reservations', 'customers' => 'Customers', 'deals' => 'Kids / Family Deals'])
    @foreach($tabs as $key => $label)
        <a href="{{ route('admin.analytics', ['tab' => $key]) }}"
           style="padding: 0.5rem 1rem; border-radius: 3px; font-size: 0.9rem; color: {{ $tab === $key ? '#0d0d10' : 'var(--color-text-muted)' }}; background: {{ $tab === $key ? 'var(--color-gold)' : 'transparent' }};">
            {{ $label }}
        </a>
    @endforeach
</div>

@if($tab === 'sales')
    @php($maxH = $data['peakHours']->max('cnt') ?: 1)
    @php($maxD = $data['peakDays']->max('cnt') ?: 1)

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
        {!! analyticsStatCard('Revenue Today', number_format($data['revenueToday'], 2) . ' DT') !!}
        {!! analyticsStatCard('Revenue This Week', number_format($data['revenueWeek'], 2) . ' DT', $data['orderCountWeek'] . ' orders') !!}
        {!! analyticsStatCard('Revenue This Month', number_format($data['revenueMonth'], 2) . ' DT') !!}
        {!! analyticsStatCard('Average Order Value', number_format($data['aov'], 2) . ' DT', $data['orderCountAll'] . ' orders (excl. cancelled)') !!}
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Revenue: Dine-in vs Delivery (all-time)</h3>
            @php($splitTotal = $data['dineInRevenue'] + $data['deliveryRevenue'])
            @if($splitTotal > 0)
                <div style="display: flex; height: 40px; border-radius: 4px; overflow: hidden; margin-bottom: 1rem;">
                    <div style="width: {{ $data['dineInRevenue'] / $splitTotal * 100 }}%; background: var(--color-gold); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: #0d0d10; font-weight: 700;">{{ round($data['dineInRevenue'] / $splitTotal * 100) }}%</div>
                    <div style="width: {{ $data['deliveryRevenue'] / $splitTotal * 100 }}%; background: #2c2c36; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: var(--color-cream);">{{ round($data['deliveryRevenue'] / $splitTotal * 100) }}%</div>
                </div>
                <div style="display: flex; gap: 2rem; font-size: 0.9rem;">
                    <span><span style="display:inline-block; width:12px; height:12px; background: var(--color-gold); border-radius:2px; margin-right:6px;"></span>Dine-in: <strong>{{ number_format($data['dineInRevenue'], 2) }} DT</strong> ({{ $data['dineInCount'] }} sales)</span>
                    <span><span style="display:inline-block; width:12px; height:12px; background:#2c2c36; border-radius:2px; margin-right:6px;"></span>Delivery: <strong>{{ number_format($data['deliveryRevenue'], 2) }} DT</strong> ({{ $data['deliveryCount'] }} orders)</span>
                </div>
            @else
                <p style="color: var(--color-text-muted);">No revenue yet. Record dine-in sales from the form below or place delivery orders.</p>
            @endif

            <hr style="border: none; border-top: 1px solid var(--color-border); margin: 1.5rem 0;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Revenue: Meal Deals vs Individual Items</h3>
            <div style="display: flex; gap: 2rem; margin-bottom: 0.5rem; font-size: 0.9rem;">
                <span>Deals ({{ $data['dealOrders'] }} orders): <strong style="color: var(--color-gold);">{{ number_format($data['dealRevenue'], 2) }} DT</strong></span>
                <span>Individual items: <strong style="color: var(--color-gold);">{{ number_format($data['regularRevenue'], 2) }} DT</strong></span>
            </div>
            <p style="font-size: 0.8rem; color: var(--color-text-muted);">Items must be flagged as "Deal / Combo" in Menu Items to appear under deals.</p>
        </div>

        <div style="display: grid; gap: 1.2rem;">
            <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
                <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Peak Hours</h3>
                @forelse($data['peakHours'] as $row)
                    {!! analyticsBarRow($row->hour . ':00', $row->cnt, $maxH, $row->cnt . ' orders') !!}
                @empty
                    <p style="color: var(--color-text-muted);">No orders yet.</p>
                @endforelse
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
                <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Peak Days</h3>
                @forelse($data['peakDays'] as $row)
                    {!! analyticsBarRow($row->day, $row->cnt, $maxD, $row->cnt . ' orders') !!}
                @empty
                    <p style="color: var(--color-text-muted);">No orders yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Payment Status Breakdown</h3>
        <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
            @forelse($data['paidSplit'] as $row)
                <span style="font-size: 0.9rem;">{{ ucfirst(str_replace('_', ' ', $row->payment_status)) }}: <strong style="color: var(--color-gold);">{{ $row->cnt }} orders / {{ number_format($row->revenue, 2) }} DT</strong></span>
            @empty
                <p style="color: var(--color-text-muted);">No orders yet.</p>
            @endforelse
        </div>
    </div>

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.2rem;">
            <h3 style="color: var(--color-gold); font-size: 1.1rem; margin: 0;">Record Dine-in Sale</h3>
            <button type="button" onclick="document.getElementById('dineInForm').style.display = document.getElementById('dineInForm').style.display === 'none' ? 'block' : 'none';" class="btn-gold" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Toggle Form</button>
        </div>
        <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 1rem;">Dine-in orders have no digital flow yet â€” log them here so the dine-in vs delivery revenue split is accurate.</p>

        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                @foreach($errors->all() as $error)<div>- {{ $error }}</div>@endforeach
            </div>
        @endif

        <div id="dineInForm" style="display: none;">
            <form action="{{ route('admin.analytics.dine-in') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group" style="margin: 0;">
                        <label>Customer Name *</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label>Phone (optional)</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                </div>

                <div style="display: flex; gap: 0.8rem; align-items: flex-end; margin-bottom: 1rem; flex-wrap: wrap;">
                    <div class="form-group" style="margin: 0; flex: 1; min-width: 260px;">
                        <label>Dish</label>
                        <select id="dineInItemSelect" class="form-control">
                            @foreach($data['menuItems'] as $item)
                                @if($item->price !== null)
                                    <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">{{ $item->category_name }} â€” {{ $item->name }} ({{ number_format($item->price, 2) }} DT)</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin: 0; width: 100px;">
                        <label>Qty</label>
                        <input type="number" id="dineInQty" class="form-control" value="1" min="1" max="99">
                    </div>
                    <button type="button" class="btn-gold" style="padding: 0.55rem 1.2rem; font-size: 0.85rem;" onclick="addDineInItem()">+ Add</button>
                </div>

                <div id="dineInItemsWrap" style="margin-bottom: 1rem;"></div>
                <div id="dineInTotal" style="font-weight: 700; margin-bottom: 1rem;">Total: 0.00 DT</div>
                <div id="dineInHidden"></div>

                <button type="submit" class="btn-gold" style="padding: 0.6rem 1.5rem; font-size: 0.9rem;">Save Dine-in Sale</button>
            </form>
        </div>
    </div>

@elseif($tab === 'menu')
    @php($maxB = $data['bestSellers']->max('qty') ?: 1)
    @php($maxC = $data['categories']->max('revenue') ?: 1)

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
        {!! analyticsStatCard('Best-Selling (units)', $data['bestSellers']->sum('qty')) !!}
        {!! analyticsStatCard('Never Ordered', $data['menuStats']->filter(fn($m) => $m->qty === null)->count() . ' items') !!}
        {!! analyticsStatCard('Items Without Cost Price', $data['itemsWithoutCost'], 'Set cost_price to unlock profitability') !!}
        {!! analyticsStatCard('Categories', $data['categories']->count()) !!}
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem; overflow-x: auto;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Best-Selling Dishes (by quantity)</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">#</th><th style="padding: 0.6rem; text-align: left;">Dish</th><th style="padding: 0.6rem; text-align: right;">Units</th><th style="padding: 0.6rem; text-align: right;">Revenue</th></tr></thead>
                <tbody>
                @forelse($data['bestSellers'] as $i => $row)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.6rem;">{{ $i + 1 }}</td>
                        <td style="padding: 0.6rem;">{{ $row->item_name }}</td>
                        <td style="padding: 0.6rem; text-align: right;">{{ $row->qty }}</td>
                        <td style="padding: 0.6rem; text-align: right; color: var(--color-gold);">{{ number_format($row->revenue, 2) }} DT</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No orders yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem; overflow-x: auto;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Worst-Selling / Never Ordered (candidates to remove)</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">Dish</th><th style="padding: 0.6rem; text-align: left;">Category</th><th style="padding: 0.6rem; text-align: right;">Units Sold</th></tr></thead>
                <tbody>
                @forelse($data['menuStats'] as $row)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.6rem;">
                            {{ $row->name }}
                            @if($row->qty === null)
                                <span style="margin-left: 0.5rem; font-size: 0.7rem; padding: 0.15rem 0.5rem; border-radius: 3px; background: rgba(231, 76, 60, 0.2); color: #e74c3c;">NEVER ORDERED</span>
                            @endif
                            @unless($row->is_available)<span style="margin-left: 0.3rem; font-size: 0.7rem; color: var(--color-text-muted);">(unavailable)</span>@endunless
                        </td>
                        <td style="padding: 0.6rem; color: var(--color-text-muted);">{{ $row->category_name }}</td>
                        <td style="padding: 0.6rem; text-align: right;">{{ $row->qty ?? 0 }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No menu items.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem; overflow-x: auto;">
            <h3 style="color: var(--color-gold); margin-bottom: 0.5rem; font-size: 1.1rem;">Most Popular (by revenue)</h3>
            <p style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 1rem;">What customers actually buy most.</p>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">Dish</th><th style="padding: 0.6rem; text-align: right;">Revenue</th></tr></thead>
                <tbody>
                @forelse($data['popular'] as $row)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);"><td style="padding: 0.6rem;">{{ $row->name }}</td><td style="padding: 0.6rem; text-align: right; color: var(--color-gold);">{{ number_format($row->revenue, 2) }} DT</td></tr>
                @empty
                    <tr><td colspan="2" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No orders yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem; overflow-x: auto;">
            <h3 style="color: var(--color-gold); margin-bottom: 0.5rem; font-size: 1.1rem;">Most Profitable (gross profit)</h3>
            <p style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 1rem;">Revenue minus cost Ã— qty. Set a cost price per dish in Menu Items.</p>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">Dish</th><th style="padding: 0.6rem; text-align: right;">Gross Profit</th></tr></thead>
                <tbody>
                @forelse($data['profitable'] as $row)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);"><td style="padding: 0.6rem;">{{ $row->name }}</td><td style="padding: 0.6rem; text-align: right; color: {{ $row->profit >= 0 ? 'var(--color-gold)' : '#e74c3c' }};">{{ number_format($row->profit, 2) }} DT</td></tr>
                @empty
                    <tr><td colspan="2" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No cost prices set yet â€” add them in Menu Items.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
        <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Category Performance</h3>
        @forelse($data['categories'] as $row)
            {!! analyticsBarRow($row->category_name, (float) $row->revenue, $maxC, number_format($row->revenue, 0) . ' DT Â· ' . $row->qty . ' sold') !!}
        @empty
            <p style="color: var(--color-text-muted);">No orders yet.</p>
        @endforelse
    </div>

@elseif($tab === 'orders')
    @php($max7 = $data['ordersLast7']->max('cnt') ?: 1)
    @php($maxW = $data['ordersLast4Weeks']->max('cnt') ?: 1)

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
        {!! analyticsStatCard('Avg Fulfilment Time', $data['avgMinutes'] !== null ? $data['avgMinutes'] . ' min' : 'â€”', 'Order placed â†’ delivered') !!}
        {!! analyticsStatCard('Deliveries Timed', $data['timedDeliveries']) !!}
        {!! analyticsStatCard('Cancelled Orders', $data['cancelledTotal']) !!}
        {!! analyticsStatCard('Failed Payments', $data['failedPayments']) !!}
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Orders â€” Last 7 Days</h3>
            @forelse($data['ordersLast7'] as $row)
                {!! analyticsBarRow($row->day, $row->cnt, $max7, $row->cnt) !!}
            @empty
                <p style="color: var(--color-text-muted);">No orders in the last 7 days.</p>
            @endforelse
        </div>
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Orders â€” Last 4 Weeks</h3>
            @forelse($data['ordersLast4Weeks'] as $row)
                {!! analyticsBarRow('W' . $row->w . ' / ' . $row->y, $row->cnt, $maxW, $row->cnt) !!}
            @empty
                <p style="color: var(--color-text-muted);">No orders in the last 4 weeks.</p>
            @endforelse
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Most Common Delivery Zones</h3>
            @php($maxZ = $data['zoneCounts']->max('cnt') ?: 1)
            @forelse($data['zoneCounts'] as $row)
                {!! analyticsBarRow($data['zones'][$row->delivery_zone_id] ?? 'Zone #' . $row->delivery_zone_id, $row->cnt, $maxZ, $row->cnt . ' orders') !!}
            @empty
                <p style="color: var(--color-text-muted);">No orders with a delivery zone yet. New checkouts capture the customer's zone.</p>
            @endforelse
        </div>
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Cancelled Orders â€” Why</h3>
            @forelse($data['cancelled'] as $row)
                <div style="display: flex; justify-content: space-between; padding: 0.6rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.9rem;">
                    <span>{{ $row->reason }}</span><strong style="color: #e74c3c;">{{ $row->cnt }}</strong>
                </div>
            @empty
                <p style="color: var(--color-text-muted);">No cancelled orders.</p>
            @endforelse
        </div>
    </div>

@elseif($tab === 'reservations')
    @php($max7 = $data['reservationsLast7']->max('cnt') ?: 1)
    @php($maxW = $data['reservationsLast4Weeks']->max('cnt') ?: 1)
    @php($maxB = $data['busiest']->max('cnt') ?: 1)

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
        {!! analyticsStatCard('Avg Party Size', $data['avgGuests'] !== null ? number_format($data['avgGuests'], 1) . ' guests' : 'â€”') !!}
        {!! analyticsStatCard('No-show Rate', $data['noShowRate'] !== null ? $data['noShowRate'] . '%' : 'â€”', 'among past reservations') !!}
        {!! analyticsStatCard('Attended (past)', $data['attended']) !!}
        {!! analyticsStatCard('No-shows (past)', $data['noShow']) !!}
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Reservations â€” Last 7 Days</h3>
            @forelse($data['reservationsLast7'] as $row)
                {!! analyticsBarRow($row->date, $row->cnt, $max7, $row->cnt) !!}
            @empty
                <p style="color: var(--color-text-muted);">No reservations in the last 7 days.</p>
            @endforelse
        </div>
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Reservations â€” Last 4 Weeks</h3>
            @forelse($data['reservationsLast4Weeks'] as $row)
                {!! analyticsBarRow('W' . $row->w . ' / ' . $row->y, $row->cnt, $maxW, $row->cnt) !!}
            @empty
                <p style="color: var(--color-text-muted);">No reservations in the last 4 weeks.</p>
            @endforelse
        </div>
    </div>

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
        <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Busiest Reservation Times (staffing)</h3>
        @forelse($data['busiest'] as $row)
            {!! analyticsBarRow($row->hour . ':00', $row->cnt, $maxB, $row->cnt . ' reservations') !!}
        @empty
            <p style="color: var(--color-text-muted);">No reservations yet.</p>
        @endforelse
        <p style="font-size: 0.8rem; color: var(--color-text-muted); margin-top: 1rem;">Tip: mark reservations "Seated" or "No Show" in Reservations so the no-show rate stays accurate.</p>
    </div>

@elseif($tab === 'customers')
    @php($maxR = $data['byPhone']->max('cnt') ?: 1)

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
        {!! analyticsStatCard('Unique Customers', $data['customerPhones']) !!}
        {!! analyticsStatCard('First-Time (by phone)', $data['newCount']) !!}
        {!! analyticsStatCard('Returning (by phone)', $data['returningCount']) !!}
        {!! analyticsStatCard('Overall Rating', $data['overallRating'] !== null ? number_format($data['overallRating'], 2) . ' / 5' : 'â€”', $data['reviewCount'] . ' reviews') !!}
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.2rem;">
        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Most Frequent Customers (loyalty candidates)</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">Name</th><th style="padding: 0.6rem; text-align: left;">Phone</th><th style="padding: 0.6rem; text-align: right;">Orders</th></tr></thead>
                <tbody>
                @forelse($data['byPhone'] as $row)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.6rem;">{{ $row->customer_name }}</td>
                        <td style="padding: 0.6rem; color: var(--color-text-muted);">{{ $row->phone }}</td>
                        <td style="padding: 0.6rem; text-align: right; color: var(--color-gold);">{{ $row->cnt }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No orders yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Rating Trends</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">Month</th><th style="padding: 0.6rem; text-align: right;">Avg Rating</th><th style="padding: 0.6rem; text-align: right;">Reviews</th></tr></thead>
                <tbody>
                @forelse($data['ratings'] as $row)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.6rem;">{{ $row->month }}</td>
                        <td style="padding: 0.6rem; text-align: right; color: var(--color-gold);">{{ number_format($row->avg_rating, 2) }}</td>
                        <td style="padding: 0.6rem; text-align: right;">{{ $row->cnt }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No reviews yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            <p style="font-size: 0.8rem; color: var(--color-text-muted); margin-top: 1rem;">New vs returning is inferred from phone number, so it works for guests too.</p>
        </div>
    </div>

@elseif($tab === 'deals')
    @php($maxC = $data['dealItems']->max('order_count') ?: 1)
    @php($groupLabels = ['kids' => 'Kids Meal', 'family' => 'Family Meal', 'other' => 'Other Deals'])

    @if($data['groupTotals']->isNotEmpty())
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
            @foreach($data['groupTotals'] as $group => $totals)
                {!! analyticsStatCard($groupLabels[$group] ?? ucfirst($group) . ' Deals', $totals['order_count'] . ' orders', $totals['qty'] . ' units Â· ' . number_format($totals['revenue'], 2) . ' DT') !!}
            @endforeach
        </div>
    @endif

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem; margin-bottom: 1.2rem;">
        <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">How Often Each Combo Deal Is Ordered</h3>
        @forelse($data['dealItems'] as $row)
            <div style="margin-bottom: 0.8rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.3rem;">
                    <span><strong>{{ $row->name }}</strong> <span style="color: var(--color-text-muted);">({{ $groupLabels[$row->deal_group] ?? ($row->deal_group ? ucfirst($row->deal_group) : 'Deal') }})</span></span>
                    <span style="color: var(--color-gold);">{{ $row->order_count }} orders Â· {{ $row->qty }} units Â· {{ number_format($row->revenue, 2) }} DT</span>
                </div>
                <div style="background: rgba(255,255,255,0.05); height: 14px; border-radius: 3px; overflow: hidden;">
                    <div style="width: {{ $row->order_count / $maxC * 100 }}%; height: 100%; background: var(--color-gold);"></div>
                </div>
            </div>
        @empty
            <p style="color: var(--color-text-muted);">No flagged deal items have been ordered yet.</p>
        @endforelse
    </div>

    <div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">
        <h3 style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">Flagged Deal Items</h3>
        <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-bottom: 1rem;">Flag a menu item as "Deal / Combo" in Menu Items to start tracking it here. The Kids item is pre-flagged.</p>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead><tr style="border-bottom: 1px solid var(--color-border); color: var(--color-text-muted);"><th style="padding: 0.6rem; text-align: left;">Dish</th><th style="padding: 0.6rem; text-align: left;">Group</th><th style="padding: 0.6rem; text-align: right;">Price</th><th style="padding: 0.6rem; text-align: right;">Units Sold</th></tr></thead>
            <tbody>
            @forelse($data['flaggedDeals'] as $row)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 0.6rem;">{{ $row->name }}</td>
                    <td style="padding: 0.6rem; color: var(--color-text-muted);">{{ $groupLabels[$row->deal_group] ?? ($row->deal_group ? ucfirst($row->deal_group) : 'â€”') }}</td>
                    <td style="padding: 0.6rem;">{{ $row->price !== null ? number_format($row->price, 2) . ' DT' : 'â€”' }}</td>
                    <td style="padding: 0.6rem; text-align: right; color: var(--color-gold);">{{ $row->qty ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">No deal items flagged yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endif

@endsection

@section('scripts')
<script>
    const dineInItems = {};

    function addDineInItem() {
        const sel = document.getElementById('dineInItemSelect');
        const qty = parseInt(document.getElementById('dineInQty').value, 10) || 1;
        const id = sel.value;
        const name = sel.options[sel.selectedIndex].dataset.name;
        const price = parseFloat(sel.options[sel.selectedIndex].dataset.price) || 0;

        if (!dineInItems[id]) dineInItems[id] = { name: name, price: price, qty: 0 };
        dineInItems[id].qty += qty;

        const wrap = document.getElementById('dineInItemsWrap');
        const keys = Object.keys(dineInItems);
        if (keys.length === 0) {
            wrap.innerHTML = '';
        } else {
            wrap.innerHTML = keys.map(function (k) {
                const it = dineInItems[k];
                return '<div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.9rem;">'
                    + '<span>' + it.name + ' Ã— ' + it.qty + '</span>'
                    + '<span><strong style="color: var(--color-gold);">' + (it.price * it.qty).toFixed(2) + ' DT</strong> '
                    + '<button type="button" onclick="removeDineInItem(\'' + k + '\')" style="background:none;border:none;color:#e74c3c;cursor:pointer;margin-left:0.8rem;"><i class="fas fa-times"></i></button></span></div>';
            }).join('');
        }

        let total = 0;
        Object.keys(dineInItems).forEach(function (k) { total += dineInItems[k].price * dineInItems[k].qty; });
        document.getElementById('dineInTotal').textContent = 'Total: ' + total.toFixed(2) + ' DT';

        const hidden = document.getElementById('dineInHidden');
        hidden.innerHTML = '';
        let i = 0;
        Object.keys(dineInItems).forEach(function (k) {
            const h1 = document.createElement('input');
            h1.type = 'hidden'; h1.name = 'items[' + i + '][id]'; h1.value = k; hidden.appendChild(h1);
            const h2 = document.createElement('input');
            h2.type = 'hidden'; h2.name = 'items[' + i + '][quantity]'; h2.value = dineInItems[k].qty; hidden.appendChild(h2);
            i++;
        });
    }

    function removeDineInItem(id) {
        delete dineInItems[id];
        addDineInItem();
    }
</script>
@endsection
