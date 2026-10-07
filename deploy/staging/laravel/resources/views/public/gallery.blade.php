@extends('layouts.app')

@section('title', 'Gallery - Bella Artista')
@section('metaDescription', __('seo.galleryDesc'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header">
        <div class="section-subtitle">{{ __('gallery.subtitle') }}</div>
        <h1>{{ __('gallery.experience') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <!-- The Restaurant: real photos -->
    <div style="margin-bottom: 4.5rem;">
        <h2 style="font-size: 1.8rem; color: var(--color-gold); border-bottom: 1px solid var(--color-border); padding-bottom: 0.8rem; margin-bottom: 2rem;">
            {{ __('gallery.restaurant') }}
        </h2>
        <div class="grid-3">
            <div class="card">
                <img src="/storage/restaurant/entrens.png" alt="Bella Artista restaurant exterior" class="card-img" style="height: 300px;" loading="lazy">
                <div class="card-body" style="padding: 1.2rem; text-align: center;">
                    <h4 style="font-family: var(--font-serif); font-size: 1.15rem;">{{ __('gallery.venue') }}</h4>
                    <div style="font-size: 0.85rem; color: var(--color-gold); margin-top: 0.3rem;">
                        <i class="fas fa-map-marked-alt" style="margin-right: 6px;"></i>{{ __('gallery.venueLabel') }}
                    </div>
                </div>
            </div>
            <div class="card">
                <img src="/storage/restaurant/bella-artista-cover.jpg" alt="Dining experience at Bella Artista" class="card-img" style="height: 300px;" loading="lazy">
                <div class="card-body" style="padding: 1.2rem; text-align: center;">
                    <h4 style="font-family: var(--font-serif); font-size: 1.15rem;">{{ __('gallery.diningExperience') }}</h4>
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.3rem;">{{ __('gallery.warmService') }}</div>
                </div>
            </div>
            <div class="card">
                <img src="/storage/restaurant/bella-artista-about.jpg" alt="Atmosphere at Bella Artista" class="card-img" style="height: 300px;" loading="lazy">
                <div class="card-body" style="padding: 1.2rem; text-align: center;">
                    <h4 style="font-family: var(--font-serif); font-size: 1.15rem;">{{ __('gallery.ourAtmosphere') }}</h4>
                    <div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.3rem;">{{ __('gallery.heartOfKorba') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- From Our Kitchen: curated dish photos -->
    <h2 style="font-size: 1.8rem; color: var(--color-gold); border-bottom: 1px solid var(--color-border); padding-bottom: 0.8rem; margin-bottom: 2rem;">
        {{ __('gallery.fromKitchen') }}
    </h2>

    @foreach($categories as $category)
        @php($photos = $category->menuItems->whereNotNull('image_url')->where('image_url', '!=', '')->take(6))
        @if($photos->count() > 0)
        <div style="margin-bottom: 4rem;">
            <h3 style="font-size: 1.4rem; color: var(--color-cream); margin-bottom: 1.5rem;">{{ $category->name }}</h3>
            <div class="grid-3">
                @foreach($photos as $item)
                <div class="card">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="card-img" style="height: 220px;" loading="lazy">
                    <div class="card-body" style="padding: 1rem; text-align: center;">
                        <h4 style="font-family: var(--font-serif); font-size: 1rem;">{{ $item->name }}</h4>
                        <div style="font-size: 0.85rem; color: var(--color-gold); margin-top: 0.3rem;">
                            {{ $item->price !== null ? number_format($item->price, 2) . ' DT' : __('gallery.onRequest') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
    @if($categories->count() === 0)
    <p style="text-align: center; color: var(--color-text-muted);">{{ __('gallery.beingUpdated') }}</p>
    @endif
</div>
@endsection
