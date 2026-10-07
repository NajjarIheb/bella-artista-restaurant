@extends('layouts.app')

@section('title', __('auth.loginTitle') . ' - ' . ($siteInfo->name ?? 'Bella Artista'))

@section('content')
<div class="section" style="padding-top: 10rem; padding-bottom: 6rem;">
    <div class="section-header" style="margin-bottom: 2.5rem;">
        <div class="section-subtitle">{{ __('auth.welcome') }}</div>
        <h1>{{ __('auth.loginTitle') }}</h1>
        <div class="divider-gold"></div>
    </div>

    <div class="auth-card" style="max-width: 460px; margin: 0 auto; background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 2.5rem;">
        @if(optional($siteInfo)->logo_url)
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <img src="{{ $siteInfo->logo_url }}" alt="{{ $siteInfo->name }}" style="width: 90px; height: 90px; object-fit: cover; border-radius: 50%; border: 1px solid var(--color-border);">
        </div>
        @endif
        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('customer.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('auth.email') }}</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}" autofocus>
            </div>

            <div class="form-group">
                <label for="password">{{ __('auth.password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <a href="{{ route('password.request') }}" style="display: inline-block; margin-top: 0.5rem; font-size: 0.85rem; color: var(--color-gold);">{{ __('auth.forgotPassword') }}</a>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="remember" id="remember" style="accent-color: var(--color-gold);">
                <label for="remember" style="margin: 0; color: var(--color-text-muted);">{{ __('auth.remember') }}</label>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%; margin-top: 0.5rem;">
                <i class="fas fa-sign-in-alt" style="margin-inline-end: 6px;"></i> {{ __('auth.loginBtn') }}
            </button>
        </form>

        <div style="display: flex; align-items: center; gap: 1rem; margin: 1.8rem 0 1.2rem;">
            <span style="flex: 1; height: 1px; background: var(--color-border);"></span>
            <span style="font-size: 0.8rem; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em;">{{ __('auth.orContinueWith') }}</span>
            <span style="flex: 1; height: 1px; background: var(--color-border);"></span>
        </div>

        <div id="googleError" style="display: none; background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 0.8rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.85rem;"></div>

        <div id="googleLoginBtn" style="display: flex; justify-content: center;"></div>

        <p style="text-align: center; margin-top: 1.8rem; color: var(--color-text-muted); font-size: 0.9rem;">
            {{ __('auth.noAccount') }} <a href="{{ route('customer.register') }}" class="text-gold">{{ __('auth.register') }}</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    const GIS_CLIENT_ID = @json(config('services.google.client_id'));
    const GIS_READY = @json((bool) config('services.google.configured'));

    function showGoogleError(message) {
        const el = document.getElementById('googleError');
        if (!el) return;
        el.textContent = message;
        el.style.display = 'block';
    }

    async function handleCredentialResponse(response) {
        if (!response || !response.credential) {
            showGoogleError(@json(__('auth.googleError')));
            return;
        }

        try {
            const res = await fetch(@json(route('customer.login.google')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token())
                },
                body: JSON.stringify({ credential: response.credential })
            });

            const data = await res.json().catch(() => ({}));

            if (res.ok && data.redirect) {
                window.location.href = data.redirect;
            } else {
                showGoogleError(data.message || @json(__('auth.googleError')));
            }
        } catch (err) {
            showGoogleError(@json(__('auth.googleError')));
        }
    }

    window.onGoogleLibraryLoad = function () {
        if (!GIS_CLIENT_ID) return;

        google.accounts.id.initialize({
            client_id: GIS_CLIENT_ID,
            callback: handleCredentialResponse
        });

        google.accounts.id.renderButton(
            document.getElementById('googleLoginBtn'),
            { theme: 'outline', size: 'large', width: 400, text: 'continue_with', shape: 'pill' }
        );
    };
</script>
@endsection
