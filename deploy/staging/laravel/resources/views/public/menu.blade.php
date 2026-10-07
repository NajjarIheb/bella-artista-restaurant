@extends('layouts.app')

@section('title', 'La Carte - Bella Artista')
@section('metaDescription', __('seo.menuDesc'))

@section('styles')
<style>
    .menu-search { max-width: 520px; margin: 0 auto 2rem; }
    .menu-item-card.hidden { display: none; }
    .menu-category.hidden { display: none; }
</style>
@endsection

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header">
        <div class="section-subtitle">{{ __('menu.subtitle') }}</div>
        <h1>{{ __('menu.laCarte') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div class="menu-search">
        <input type="text" id="menuSearch" class="form-control" placeholder="{{ __('menu.searchPlaceholder', ['count' => $categories->sum(fn($c) => $c->menuItems->count())]) }}" autocomplete="off">
    </div>

    <div style="text-align: center; margin-bottom: 3rem;">
        @foreach($categories as $category)
        <a href="#cat-{{ $category->id }}" class="cat-chip" data-cat-id="{{ $category->id }}" style="display: inline-block; padding: 0.4rem 1rem; margin: 0.25rem 0.35rem; border: 1px solid var(--color-border); border-radius: 20px; cursor: pointer; font-size: 0.85rem; color: var(--color-text-muted); text-decoration: none;">{{ $category->name }}</a>
        @endforeach
    </div>

    @foreach($categories as $category)
    <div class="menu-category" id="cat-{{ $category->id }}" data-category-name="{{ strtolower($category->name) }}" style="margin-bottom: 5rem;">
        <h2 style="font-size: 2.2rem; color: var(--color-gold); border-bottom: 1px solid var(--color-border); padding-bottom: 0.8rem; margin-bottom: 2.5rem;">
            {{ $category->name }}
        </h2>

        <div class="grid-3">
            @foreach($category->menuItems as $item)
            <div class="card menu-item-card" data-search="{{ strtolower($item->name . ' ' . ($item->description ?? '') . ' ' . $category->name) }}">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="card-img" loading="lazy">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{ $item->name }}</h3>
                        <span class="card-price">{{ $item->price !== null ? number_format($item->price, 2) . ' DT' : __('menu.onRequest') }}</span>
                    </div>
                    <p>{{ $item->description }}</p>
                    @if($item->allergens)
                    <span class="badge-tag"><i class="fas fa-info-circle" style="margin-right: 4px;"></i> {{ $item->allergens }}</span>
                    @endif
                    <div style="margin-top: 1rem;">
                        @if($item->price !== null)
                        <button type="button" class="btn-gold add-to-cart" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" style="width: 100%; padding: 0.6rem; font-size: 0.85rem;">
                            <i class="fas fa-cart-plus" style="margin-right: 6px;"></i> {{ __('menu.addToCart') }}
                        </button>
                        @else
                        <button type="button" class="btn-gold" disabled style="width: 100%; padding: 0.6rem; font-size: 0.85rem;">{{ __('menu.onRequest') }}</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div style="text-align: center; background: var(--bg-card); padding: 3rem; border: 1px solid var(--color-border); border-radius: 4px; margin-top: 3rem;">
        <h3 style="margin-bottom: 1rem;">{{ __('menu.experience') }}</h3>
        <p style="margin-bottom: 2rem;">{{ __('menu.weOffer') }}</p>
        <a href="{{ route('delivery') }}" class="btn-gold">{{ __('menu.orderDelivery') }}</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('menuSearch');

    function applyMenuFilter() {
        const term = (searchInput.value || '').toLowerCase().trim();

        document.querySelectorAll('.menu-category').forEach(cat => {
            let anyShown = false;
            cat.querySelectorAll('.menu-item-card').forEach(card => {
                const show = term === '' || card.dataset.search.includes(term);
                card.classList.toggle('hidden', !show);
                if (show) anyShown = true;
            });
            cat.classList.toggle('hidden', !anyShown);
        });
    }

    searchInput.addEventListener('input', applyMenuFilter);

    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function () {
            Cart.add(this.dataset.id);
            this.innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i> {{ __('menu.addedToCart') }}';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-cart-plus" style="margin-right: 6px;"></i> {{ __('menu.addToCart') }}';
            }, 1200);
        });
    });
</script>
@endsection
