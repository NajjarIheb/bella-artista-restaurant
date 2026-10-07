@extends('layouts.app')

@section('title', 'Contact Us - Bella Artista')
@section('metaDescription', __('seo.contactDesc'))

@section('content')
<div class="section" style="padding-top: 10rem;">
    <div class="section-header">
        <div class="section-subtitle">{{ __('contact.subtitle') }}</div>
        <h1>{{ __('contact.location') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 4rem;">
        <div style="background: var(--bg-card); padding: 3rem; border: 1px solid var(--color-border); border-radius: 4px;">
            <h3 style="color: var(--color-gold); margin-bottom: 2rem;">{{ __('contact.details') }}</h3>

            <div style="margin-bottom: 2rem;">
                <h4 style="font-size: 1.1rem; color: var(--color-cream); margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt text-gold" style="margin-inline-end: 10px;"></i> {{ __('contact.address') }}</h4>
                <p>{{ $info->address ?? __('contact.addressFallback') }}</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <h4 style="font-size: 1.1rem; color: var(--color-cream); margin-bottom: 0.5rem;"><i class="fas fa-phone text-gold" style="margin-inline-end: 10px;"></i> {{ __('contact.phone') }}</h4>
                <p>{{ $info->phone ?? __('contact.phoneFallback') }}</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <h4 style="font-size: 1.1rem; color: var(--color-cream); margin-bottom: 0.5rem;"><i class="fas fa-clock text-gold" style="margin-inline-end: 10px;"></i> {{ __('contact.hours') }}</h4>
                <p style="white-space: pre-line;">{{ $info->hours ?? __('contact.hoursFallback') }}</p>
            </div>

            <div>
                <h4 style="font-size: 1.1rem; color: var(--color-cream); margin-bottom: 0.8rem;"><i class="fas fa-share-alt text-gold" style="margin-inline-end: 10px;"></i> {{ __('contact.followUs') }}</h4>
                <div style="display: flex; gap: 1.5rem; font-size: 1.5rem;">
                    <a href="#" class="text-gold"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gold"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gold"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- Google Map Embed -->
        <div style="border: 1px solid var(--color-border); border-radius: 4px; overflow: hidden; height: 100%; min-height: 400px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.83543450937!2d144.9537363153169!3d-37.81627977975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
@endsection
