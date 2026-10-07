@extends('layouts.app')

@section('title', __('auth.resetTitle') . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem; padding-bottom: 6rem;">
    <div class="section-header" style="margin-bottom: 2.5rem;">
        <div class="section-subtitle">{{ __('auth.forgotPassword') }}</div>
        <h1>{{ __('auth.resetTitle') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div class="auth-card" style="max-width: 460px; margin: 0 auto; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2.5rem;">
        @if(session('status'))
            <div style="background: rgba(46, 204, 113, 0.15); border: 1px solid rgba(46, 204, 113, 0.4); color: #2ecc71; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <p style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">{{ __('auth.resetHint') }}</p>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('auth.email') }}</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" autofocus>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%; margin-top: 0.5rem;">
                <i class="fas fa-paper-plane" style="margin-inline-end: 6px;"></i> {{ __('auth.resetSend') }}
            </button>
        </form>

        <p style="text-align: center; margin-top: 1.8rem; color: var(--color-text-muted); font-size: 0.9rem;">
            <a href="{{ route('customer.login') }}" class="text-gold">{{ __('auth.backToLogin') }}</a>
        </p>
    </div>
</div>
@endsection
