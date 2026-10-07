@extends('layouts.app')

@section('title', ($siteInfo->name ?? 'Bella Artista') . ' - Restaurant & Café')
@section('metaDescription', __('seo.homeDesc'))

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-subtitle">{{ __('hero.subtitle') }}</div>
        <h1 class="hero-title">{!! __('hero.title') !!}</h1>
        <p class="hero-desc">{{ __('hero.desc') }}</p>
        <div class="hero-actions">
            <a href="{{ route('reservations') }}" class="btn-gold">{{ __('hero.reserve') }}</a>
            <a href="{{ route('delivery') }}" class="btn-outline">{{ __('hero.orderDelivery') }}</a>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="section">
    <div class="section-header">
        <div class="section-subtitle">{{ __('home.philosophy') }}</div>
        <h2>{{ __('home.artistry') }}</h2>
        <div class="divider-gold"></div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 4rem; align-items: center;">
        <div>
            <p style="font-size: 1.1rem; line-height: 1.9; margin-bottom: 1.5rem;">
                {{ __('home.p1') }}
            </p>
            <p style="font-size: 1.05rem; line-height: 1.8;">
                {{ __('home.p2') }}
            </p>
            <div style="margin-top: 2rem;">
                <a href="{{ route('about') }}" class="btn-outline">{{ __('home.discoverStory') }}</a>
            </div>
        </div>
        <div>
            <img src="/storage/restaurant/entrens.png" alt="Bella Artista restaurant exterior" class="card-img" style="height: 300px;" loading="lazy">
        </div>
    </div>
</section>

<!-- Featured Menu -->
<section class="section" style="background: rgba(20, 20, 24, 0.4); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border); max-width: 100%;">
    <div style="max-width: 1250px; margin: 0 auto;">
        <div class="section-header">
            <div class="section-subtitle">{{ __('home.chefHighlights') }}</div>
            <h2>{{ __('home.selectedCreations') }}</h2>
            <div class="divider-gold"></div>
        </div>

        <div class="grid-3">
            @foreach($featuredItems as $item)
            <div class="card">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="card-img" loading="lazy">
                <div class="card-body">
                    <div class="card-title">
                        <h3>{{ $item->name }}</h3>
                        <span class="card-price">{{ $item->price !== null ? number_format($item->price, 2) . ' DT' : __('home.onRequest') }}</span>
                    </div>
                    <p>{{ $item->description }}</p>
                    @if($item->allergens)
                    <span class="badge-tag"><i class="fas fa-info-circle" style="margin-right: 4px;"></i> {{ $item->allergens }}</span>
                    @endif
                    <div style="margin-top: 1rem;">
                        @if($item->price !== null)
                        <button type="button" class="btn-gold add-to-cart" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" style="width: 100%; padding: 0.6rem; font-size: 0.85rem;">
                            <i class="fas fa-cart-plus" style="margin-right: 6px;"></i> {{ __('home.addToCart') }}
                        </button>
                        @else
                        <button type="button" class="btn-gold" disabled style="width: 100%; padding: 0.6rem; font-size: 0.85rem;">{{ __('home.onRequest') }}</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="{{ route('delivery') }}" class="btn-outline" style="margin-right: 1rem;">{{ __('home.goToCartCheckout') }}</a>
            <a href="{{ route('menu') }}" class="btn-gold">{{ __('home.exploreFullMenu') }}</a>
        </div>
    </div>
</section>

<!-- Reviews / Testimonials -->
<section class="section">
    <div class="section-header">
        <div class="section-subtitle">{{ __('home.patronExperiences') }}</div>
        <h2>{{ __('home.wordsFromGuests') }}</h2>
        <div class="divider-gold"></div>
    </div>

    <div class="grid-3">
        @foreach($reviews as $review)
        <div style="background: var(--bg-card); padding: 2.5rem; border: 1px solid var(--color-border); border-radius: 4px;">
            <div style="color: var(--color-gold); margin-bottom: 1rem; font-size: 1.1rem;">
                @for($i=0; $i<$review->rating; $i++)
                    <i class="fas fa-star"></i>
                @endfor
            </div>
            <p style="font-style: italic; font-size: 1.05rem; margin-bottom: 1.5rem; color: var(--color-cream);">"{{ $review->comment }}"</p>
            <h4 style="font-size: 1.1rem;">{{ $review->customer_name }}</h4>
        </div>
        @endforeach
    </div>
</section>
@endsection

@section('scripts')
<script>
    const ADDED_LABEL = "{{ __('home.addedToCart') }}";
    const ADD_LABEL = "{{ __('home.addToCart') }}";
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function () {
            Cart.add(this.dataset.id);
            this.innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i> ' + ADDED_LABEL;
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-cart-plus" style="margin-right: 6px;"></i> ' + ADD_LABEL;
            }, 1200);
        });
    });
</script>
@endsection
