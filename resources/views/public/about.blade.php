@extends('layouts.app')

@section('title', 'About Us - Bella Artista')
@section('metaDescription', __('seo.aboutDesc'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header">
        <div class="section-subtitle">{{ __('about.subtitle') }}</div>
        <h1>{{ __('about.culinaryLegacy') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 4rem; align-items: center; margin-bottom: 6rem;">
        <div>
            <h3 style="color: var(--color-gold); margin-bottom: 1.5rem;">{{ __('about.concept') }}</h3>
            <p style="font-size: 1.1rem; line-height: 1.9; margin-bottom: 1.5rem;">
                {{ $info->about ?? __('about.aboutFallback') }}
            </p>
            <p style="font-size: 1.05rem; line-height: 1.8;">
                {{ __('about.conceptP2') }}
            </p>
        </div>
        <div>
            @if($info->cover_url)
                <img src="{{ $info->cover_url }}" alt="Bella Artista" style="width: 100%; border-radius: 4px; border: 1px solid var(--color-border);" loading="lazy">
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 4rem; align-items: center;">
        <div>
            <div style="overflow: hidden; border-radius: 4px; border: 1px solid var(--color-border); margin-bottom: 1rem;">
                <img src="/storage/restaurant/bella-artista-about.jpg" alt="Bella Artista" style="width: 100%; height: 240px; object-fit: cover; display: block;" loading="lazy">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            @foreach($galleryItems as $gi)
                <div style="overflow: hidden; border-radius: 4px; border: 1px solid var(--color-border);">
                    <img src="{{ $gi->image_url }}" alt="{{ $gi->name }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" loading="lazy">
                </div>
            @endforeach
            </div>
        </div>
        <div>
            <h3 style="color: var(--color-gold); margin-bottom: 1.5rem;">{{ __('about.visitKorba') }}</h3>
            <p style="font-size: 1.05rem; line-height: 1.9; margin-bottom: 1.5rem;">
                <?php $rating = (float) $info->rating; ?>
                @if($rating)
                <span class="badge-tag" style="margin-bottom: 1rem; display: inline-block;">
                    <i class="fas fa-star" style="color: var(--color-gold);"></i> {{ __('about.rated', ['rating' => number_format($rating, 1)]) }}
                </span>
                @endif
            </p>
            <ul style="list-style: none; font-size: 1.05rem; line-height: 2.2;">
                <li><i class="fas fa-map-marker-alt text-gold" style="width: 25px;"></i> {{ $info->address }}</li>
                <li><i class="fas fa-clock text-gold" style="width: 25px;"></i> {{ $info->hours }}</li>
                <li><i class="fas fa-phone text-gold" style="width: 25px;"></i> {{ $info->phone }}</li>
                @if($info->plus_code)
                <li><i class="fas fa-compass text-gold" style="width: 25px;"></i> {{ __('about.plusCode') }} {{ $info->plus_code }}</li>
                @endif
            </ul>
            @if($info->maps_url)
            <a href="{{ $info->maps_url }}" target="_blank" class="btn-gold" style="margin-top: 1.5rem; display: inline-block;">
                <i class="fas fa-directions" style="margin-right: 6px;"></i> {{ __('about.getDirections') }}
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
