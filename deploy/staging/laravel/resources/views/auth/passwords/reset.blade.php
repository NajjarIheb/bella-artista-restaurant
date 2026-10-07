@extends('layouts.app')

@section('title', __('auth.resetTitle') . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem; padding-bottom: 6rem;">
    <div class="section-header" style="margin-bottom: 2.5rem;">
        <div class="section-subtitle">{{ __('auth.resetTitle') }}</div>
        <h1>{{ __('auth.newPassword') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div class="auth-card" style="max-width: 460px; margin: 0 auto; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2.5rem;">
        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">{{ __('auth.email') }}</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ $email ?? old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">{{ __('auth.newPassword') }}</label>
                <input type="password" id="password" name="password" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('auth.confirmPassword') }}</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%; margin-top: 0.5rem;">
                <i class="fas fa-key" style="margin-inline-end: 6px;"></i> {{ __('auth.resetSubmit') }}
            </button>
        </form>

        <p style="text-align: center; margin-top: 1.8rem; color: var(--color-text-muted); font-size: 0.9rem;">
            <a href="{{ route('customer.login') }}" class="text-gold">{{ __('auth.backToLogin') }}</a>
        </p>
    </div>
</div>
@endsection
