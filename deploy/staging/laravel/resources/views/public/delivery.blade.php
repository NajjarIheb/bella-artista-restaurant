@extends('layouts.app')

@section('title', 'Order Delivery - Bella Artista')
@section('metaDescription', __('seo.deliveryDesc'))

@section('styles')
<style>
    .dish-list { max-height: 70vh; overflow-y: auto; padding-right: 0.5rem; }
    .dish-item { display: flex; gap: 1rem; align-items: center; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .dish-item.hidden { display: none; }
    .dish-img { width: 74px; height: 60px; object-fit: cover; border-radius: 4px; flex-shrink: 0; }
    .dish-info { flex: 1; min-width: 0; }
    .qty-btn { width: 30px; height: 30px; border: 1px solid var(--color-border); background: rgba(255,255,255,0.05); color: var(--color-cream); cursor: pointer; border-radius: 3px; font-size: 1rem; line-height: 1; }
    .qty-btn:hover { border-color: var(--color-gold); color: var(--color-gold); }
    .cart-sticky { position: sticky; top: 6rem; }
    .cart-scroll { max-height: 260px; overflow-y: auto; padding-right: 0.3rem; }
    .cart-scroll::-webkit-scrollbar { width: 6px; }
    .cart-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 3px; }
    .cart-scroll::-webkit-scrollbar-thumb { background: var(--color-gold); border-radius: 3px; }
    .cart-line { display: flex; align-items: center; gap: 0.8rem; padding: 0.7rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .cart-line .qty { min-width: 24px; text-align: center; font-weight: 600; }
    .cat-chip { display: inline-block; padding: 0.4rem 1rem; margin: 0.25rem 0.35rem 0.25rem 0; border: 1px solid var(--color-border); border-radius: 20px; cursor: pointer; font-size: 0.85rem; color: var(--color-text-muted); background: transparent; }
    .cat-chip:hover { border-color: var(--color-gold); color: var(--color-gold); }
    .cat-chip.active { background: var(--color-gold); color: #0d0d10; border-color: var(--color-gold); }
    .btn-gold[disabled] { opacity: 0.5; cursor: not-allowed; }

    @media (max-width: 850px) {
        .section { padding-top: 6rem !important; padding-bottom: 6rem !important; display: flex; flex-direction: column; }
        .order-builder { grid-template-columns: 1fr !important; gap: 1.5rem !important; order: 2; }
        .info-cards { order: 3; }
        #checkoutForm { order: 4; }
        .cart-sticky { position: static !important; order: -1; }
        .dish-list { max-height: 55vh; }
        .dish-item { flex-wrap: nowrap; }
        .dish-item .dish-info { min-width: 0; }
        .dish-item .add-btn,
        .dish-item .btn-gold { width: auto; padding: 0.4rem 0.8rem; font-size: 0.8rem; flex-shrink: 0; }
        #mobileCartBar { display: flex; }
    }
</style>
@endsection

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header">
        <div class="section-subtitle">{{ __('delivery.subtitle') }}</div>
        <h1>{{ __('delivery.orderTitle') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <!-- Info Cards Grid -->
    <div class="grid-3 info-cards" style="margin-bottom: 4rem;">
        <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px; text-align: center;">
            <i class="fas fa-user-shield text-gold" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3>{{ __('delivery.directStaff') }}</h3>
            <p>{{ __('delivery.directStaffDesc') }}</p>
        </div>

        <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px; text-align: center;">
            <i class="fas fa-map-marked-alt text-gold" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3>{{ __('delivery.coverageFee') }}</h3>
            <p>{{ __('delivery.coverage') }} <strong>{{ $info->delivery_radius ?? __('delivery.km') }}</strong><br>
            {{ __('delivery.deliveryFee') }} <strong>{{ $info->delivery_fee !== null ? number_format($info->delivery_fee, 2) . ' DT' : '0.00 DT' }}</strong><br>
            @if($zones->isNotEmpty())
                {{ __('delivery.zoneFeeVaries') }} <strong>{{ number_format($zones->min('delivery_fee'), 2) }} – {{ number_format($zones->max('delivery_fee'), 2) }} DT</strong><br>
            @endif
            {{ __('delivery.minimumOrder') }} <strong>{{ number_format($info->min_order_amount ?? 0, 2) }} DT</strong></p>
        </div>

        <div style="background: var(--bg-card); padding: 2rem; border: 1px solid var(--color-border); border-radius: 4px; text-align: center;">
            <i class="fas fa-money-bill-wave text-gold" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3>{{ __('delivery.paymentMethod') }}</h3>
            <p><strong>{{ __('delivery.codOnly') }}</strong><br>{{ __('delivery.paymentDesc') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
            @if(session('track_order_id'))
                <a href="{{ route('track.order') }}" style="color: inherit; text-decoration: underline; margin-inline-start: 6px;">{{ __('delivery.trackOrderLink') }}</a>
            @endif
        </div>
    @endif

    @if($errors->any())
        <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <ul style="margin-left: 1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Order Builder -->
    <div class="order-builder" style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem;">

        <!-- Dish List -->
        <div>
            <div class="form-group">
                <label style="color: var(--color-gold); font-size: 1rem;">{{ __('delivery.searchDishes') }}</label>
                <input type="text" id="dishSearch" class="form-control" placeholder="{{ __('delivery.searchPlaceholder', ['count' => count($menuItems)]) }}" autocomplete="off">
            </div>

            <div id="categoryChips" style="margin-bottom: 1rem;">
                <button type="button" class="cat-chip active" data-cat="all">{{ __('delivery.all') }}</button>
                @foreach($categories as $cat)
                    <button type="button" class="cat-chip" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
                @endforeach
            </div>

            <div id="dishList" class="dish-list">
                @foreach($menuItems as $item)
                <div class="dish-item"
                     data-id="{{ $item->id }}"
                     data-name="{{ $item->name }}"
                     data-price="{{ $item->price !== null ? $item->price : '' }}"
                     data-category="{{ $item->category_id }}"
                     data-search="{{ strtolower($item->name . ' ' . ($item->description ?? '') . ' ' . ($item->category->name ?? '')) }}">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="dish-img" loading="lazy">
                    <div class="dish-info">
                        <strong>{{ $item->name }}</strong>
                        <div style="font-size: 0.85rem; color: var(--color-gold);">
                            {{ $item->price !== null ? number_format($item->price, 2) . ' DT' : __('delivery.onRequest') }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">{{ $item->description }}</div>
                    </div>
                    @if($item->price !== null)
                        <button type="button" class="btn-gold add-btn" data-id="{{ $item->id }}" style="padding: 0.5rem 1rem; font-size: 0.85rem; flex-shrink: 0;">
                            <i class="fas fa-plus"></i> {{ __('delivery.add') }}
                        </button>
                    @else
                        <button type="button" class="btn-gold" disabled style="padding: 0.5rem 1rem; font-size: 0.85rem; flex-shrink: 0;">{{ __('delivery.onRequest') }}</button>
                    @endif
                </div>
                @endforeach
                <p id="noResults" style="display: none; text-align: center; color: var(--color-text-muted); padding: 2rem;">{{ __('delivery.noResults') }}</p>
            </div>
        </div>

        <!-- Cart -->
        <div class="cart-sticky" style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.8rem;">
            <h3 style="color: var(--color-gold); margin-bottom: 1.2rem; display: flex; align-items: center; gap: 0.6rem;">
                <i class="fas fa-shopping-cart"></i> {{ __('delivery.yourOrder') }}
            </h3>

            <div id="cartItems" class="cart-scroll" style="margin-bottom: 1rem;">
                <p style="color: var(--color-text-muted); font-size: 0.9rem;">{{ __('delivery.cartEmpty') }}</p>
            </div>

            <div style="border-top: 1px solid var(--color-border); padding-top: 1rem; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: var(--color-text-muted);">{{ __('delivery.subtotal') }}</span>
                    <span id="cartSubtotal">0.00 DT</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span style="color: var(--color-text-muted);">{{ __('delivery.deliveryFeeLabel') }}</span>
                    <span id="cartDelivery">0.00 DT</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.15rem; font-weight: 700;">
                    <span>{{ __('delivery.total') }}</span>
                    <span id="cartTotal">0.00 DT</span>
                </div>
                <div id="minOrderWarning" style="display: none; margin-top: 0.8rem; font-size: 0.85rem; color: #e74c3c;">
                    <i class="fas fa-exclamation-triangle"></i> {{ __('delivery.minOrderWarning', ['amount' => number_format($info->min_order_amount ?? 0, 2)]) }}
                </div>
            </div>

            <button type="button" id="placeOrderBtn" class="btn-gold" style="width: 100%;" disabled>
                <i class="fas fa-arrow-right" style="margin-right: 6px;"></i> {{ __('delivery.placeOrder') }}
            </button>
        </div>
    </div>

    <!-- Mobile sticky order-cost bar -->
    <div id="mobileCartBar" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background: var(--bg-card); border-top: 1px solid var(--color-border); padding: 0.7rem 1rem; z-index: 1500; align-items: center; gap: 1rem; box-shadow: 0 -5px 20px rgba(0,0,0,0.5);">
        <div style="flex: 1; min-width: 0; line-height: 1.5;">
            <div style="font-size: 0.8rem; color: var(--color-text-muted);">{{ __('delivery.subtotal') }} <span id="mbSubtotal" style="color: var(--color-cream);">0.00 DT</span></div>
            <div style="font-weight: 700; font-size: 1.05rem;">{{ __('delivery.total') }} <span id="mbTotal">0.00 DT</span></div>
        </div>
        <button type="button" id="mbPlaceOrderBtn" class="btn-gold" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; flex-shrink: 0;" disabled>
            <i class="fas fa-shopping-cart" style="margin-right: 6px;"></i> {{ __('delivery.placeOrder') }}
        </button>
    </div>

    <!-- Checkout Form (hidden until Place Order clicked) -->
    <div id="checkoutForm" style="display: none; margin-top: 3rem; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2.5rem;">
        <h3 style="text-align: center; margin-bottom: 2rem; color: var(--color-gold);">{{ __('delivery.checkoutTitle') }}</h3>

        <form action="{{ route('delivery.store') }}" method="POST" id="deliveryForm">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <div class="form-group">
                    <label for="customer_name">{{ __('delivery.fullName') }}</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control" required value="{{ old('customer_name', auth()->check() ? auth()->user()->name : '') }}">
                </div>

                <div class="form-group">
                    <label for="phone">{{ __('delivery.phone') }}</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required value="{{ old('phone', auth()->check() ? auth()->user()->phone : '') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="address">{{ __('delivery.address') }}</label>
                <textarea id="address" name="address" rows="3" class="form-control" placeholder="{{ __('delivery.addressPlaceholder') }}" required>{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <label for="delivery_zone_id">{{ __('delivery.deliveryZone') }}</label>
                <select id="delivery_zone_id" name="delivery_zone_id" class="form-control" onchange="renderCart()">
                    @forelse($zones as $zone)
                        <option value="{{ $zone->id }}" data-fee="{{ $zone->delivery_fee }}" {{ old('delivery_zone_id', $zones->first()->id ?? '') == $zone->id ? 'selected' : '' }}>
                            {{ $zone->area_name }} — {{ number_format($zone->delivery_fee, 2) }} DT
                        </option>
                    @empty
                        <option value="" data-fee="{{ $info->delivery_fee ?? 0 }}" selected>{{ __('delivery.standardZone') }} — {{ number_format($info->delivery_fee ?? 0, 2) }} DT</option>
                    @endforelse
                </select>
            </div>

            <div class="form-group">
                <label for="notes">{{ __('delivery.notes') }}</label>
                <textarea id="notes" name="notes" rows="2" class="form-control" placeholder="{{ __('delivery.notesPlaceholder') }}">{{ old('notes') }}</textarea>
            </div>

            <div id="hiddenItems"></div>

            <div class="form-group">
                <label style="color: var(--color-gold); font-size: 1rem; display: block; margin-bottom: 0.8rem;">
                    <i class="fas fa-credit-card" style="margin-inline-end: 6px;"></i> {{ __('payment.selectMethod') }}
                </label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                    <label class="pay-opt" style="display: flex; gap: 0.9rem; align-items: flex-start; padding: 1.1rem; border: 1px solid var(--color-border); border-radius: 4px; cursor: pointer; background: rgba(255,255,255,0.02);">
                        <input type="radio" name="payment_method" value="cash_on_delivery" {{ old('payment_method', 'cash_on_delivery') === 'cash_on_delivery' ? 'checked' : '' }} style="margin-top: 4px;">
                        <span>
                            <strong style="display: block;">{{ __('payment.cod') }}</strong>
                            <span style="font-size: 0.85rem; color: var(--color-text-muted);">{{ __('payment.codDesc') }}</span>
                        </span>
                    </label>
                    <label class="pay-opt" style="display: flex; gap: 0.9rem; align-items: flex-start; padding: 1.1rem; border: 1px solid var(--color-border); border-radius: 4px; cursor: pointer; background: rgba(255,255,255,0.02);">
                        <input type="radio" name="payment_method" value="flouci_card" {{ old('payment_method') === 'flouci_card' ? 'checked' : '' }} style="margin-top: 4px;">
                        <span>
                            <strong style="display: block;">{{ __('payment.flouci') }}</strong>
                            <span style="font-size: 0.85rem; color: var(--color-text-muted);">{{ __('payment.flouciDesc') }}</span>
                        </span>
                    </label>
                </div>
            </div>

            <div id="paymentNote" style="background: rgba(212, 175, 55, 0.08); padding: 1.2rem; border-inline-start: 3px solid var(--color-gold); margin-bottom: 2rem;">
                <p style="font-size: 0.9rem; color: var(--color-cream); margin: 0;">
                    <i class="fas fa-info-circle text-gold"></i> <strong>{{ __('delivery.note') }}</strong> <span id="paymentNoteText">{{ __('delivery.cashOnDelivery') }}. {{ __('delivery.exactAmount') }}</span>
                </p>
            </div>

            <button type="submit" id="confirmOrderBtn" class="btn-gold" style="width: 100%;">{{ __('delivery.confirm') }}</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const FALLBACK_FEE = {{ $info->delivery_fee ?? 0 }};
    const MIN_ORDER = {{ $info->min_order_amount ?? 0 }};
    const CART_EMPTY = "{{ __('delivery.cartEmpty') }}";
    const EACH_LABEL = "{{ __('delivery.each') }}";

    function currentFee() {
        const sel = document.getElementById('delivery_zone_id');
        if (sel && sel.options.length) {
            const fee = parseFloat(sel.options[sel.selectedIndex].dataset.fee);
            if (!isNaN(fee)) return fee;
        }
        return FALLBACK_FEE;
    }

    const dishData = {};

    document.querySelectorAll('.dish-item').forEach(el => {
        dishData[el.dataset.id] = {
            name: el.dataset.name,
            price: parseFloat(el.dataset.price) || 0,
        };
    });

    function fmt(n) {
        return n.toFixed(2) + ' DT';
    }

    function addToCart(id) {
        Cart.add(id);
        renderCart();
    }

    function changeQty(id, delta) {
        Cart.changeQty(id, delta);
        renderCart();
    }

    function renderCart() {
        const cart = Cart.get();
        const wrap = document.getElementById('cartItems');
        wrap.innerHTML = '';

        let subtotal = 0;
        const ids = Object.keys(cart);

        if (ids.length === 0) {
            wrap.innerHTML = '<p style="color: var(--color-text-muted); font-size: 0.9rem;">' + CART_EMPTY + '</p>';
        } else {
            ids.forEach(id => {
                const d = dishData[id];
                if (!d) return;
                const qty = cart[id];
                const lineTotal = d.price * qty;
                subtotal += lineTotal;

                const line = document.createElement('div');
                line.className = 'cart-line';
                line.innerHTML =
                    '<div style="flex: 1; min-width: 0;">' +
                        '<div style="font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' + d.name + '</div>' +
                        '<div style="font-size: 0.8rem; color: var(--color-gold);">' + fmt(d.price) + ' ' + EACH_LABEL + '</div>' +
                    '</div>' +
                    '<button type="button" class="qty-btn" onclick="changeQty(' + id + ', -1)">-</button>' +
                    '<span class="qty">' + qty + '</span>' +
                    '<button type="button" class="qty-btn" onclick="changeQty(' + id + ', 1)">+</button>' +
                    '<span style="min-width: 76px; text-align: right; font-size: 0.9rem;">' + fmt(lineTotal) + '</span>';
                wrap.appendChild(line);
            });
        }

        const fee = currentFee();
        const total = subtotal + fee;
        document.getElementById('cartSubtotal').textContent = fmt(subtotal);
        document.getElementById('cartDelivery').textContent = fmt(fee);
        document.getElementById('cartTotal').textContent = fmt(total);

        const meetsMin = subtotal >= MIN_ORDER;
        const btn = document.getElementById('placeOrderBtn');
        btn.disabled = ids.length === 0 || !meetsMin;
        document.getElementById('minOrderWarning').style.display = (ids.length > 0 && !meetsMin) ? 'block' : 'none';

        const mbBar = document.getElementById('mobileCartBar');
        if (mbBar) {
            const mbSubtotal = document.getElementById('mbSubtotal');
            const mbTotal = document.getElementById('mbTotal');
            const mbBtn = document.getElementById('mbPlaceOrderBtn');
            if (mbSubtotal) mbSubtotal.textContent = fmt(subtotal);
            if (mbTotal) mbTotal.textContent = fmt(total);
            if (mbBtn) mbBtn.disabled = ids.length === 0 || !meetsMin;
            mbBar.style.display = (ids.length === 0) ? 'none' : '';
        }
    }

    function buildHiddenInputs() {
        const cart = Cart.get();
        const container = document.getElementById('hiddenItems');
        container.innerHTML = '';
        let i = 0;
        for (const id in cart) {
            const hid = document.createElement('input');
            hid.type = 'hidden';
            hid.name = 'items[' + i + '][id]';
            hid.value = id;
            container.appendChild(hid);

            const qty = document.createElement('input');
            qty.type = 'hidden';
            qty.name = 'items[' + i + '][quantity]';
            qty.value = cart[id];
            container.appendChild(qty);

            i++;
        }
    }

    document.querySelectorAll('.add-btn').forEach(btn => {
        btn.addEventListener('click', () => addToCart(btn.dataset.id));
    });

    function openCheckout() {
        buildHiddenInputs();
        const form = document.getElementById('checkoutForm');
        form.style.display = 'block';
        form.scrollIntoView({ behavior: 'smooth' });
    }

    document.getElementById('placeOrderBtn').addEventListener('click', openCheckout);
    document.getElementById('mbPlaceOrderBtn').addEventListener('click', openCheckout);

    window.addEventListener('cartchange', renderCart);

    // Search + category filter
    const searchInput = document.getElementById('dishSearch');
    let activeCategory = 'all';

    function applyFilters() {
        const term = (searchInput.value || '').toLowerCase().trim();
        let shown = 0;

        document.querySelectorAll('.dish-item').forEach(el => {
            const matchesSearch = term === '' || el.dataset.search.includes(term);
            const matchesCat = activeCategory === 'all' || el.dataset.category === activeCategory;
            const show = matchesSearch && matchesCat;
            el.classList.toggle('hidden', !show);
            if (show) shown++;
        });

        document.getElementById('noResults').style.display = shown === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', applyFilters);

    document.querySelectorAll('#categoryChips .cat-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('#categoryChips .cat-chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeCategory = chip.dataset.cat;
            applyFilters();
        });
    });

    const PAY_NAV = {
        cash_on_delivery: "{{ __('delivery.cashOnDelivery') }}. {{ __('delivery.exactAmount') }}",
        flouci_card: "{{ __('payment.redirecting') }}"
    };

    const confirmBtn = document.getElementById('confirmOrderBtn');
    const noteText = document.getElementById('paymentNoteText');

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', () => {
            if (noteText && PAY_NAV[radio.value]) {
                noteText.textContent = PAY_NAV[radio.value];
            }
            if (confirmBtn) {
                confirmBtn.textContent = radio.value === 'flouci_card' ? "{{ __('payment.payNow') }}" : "{{ __('delivery.confirm') }}";
            }
        });
    });
    @if(session('success'))
    if (window.Cart) Cart.clear();
    @endif

    renderCart();

</script>
@endsection
