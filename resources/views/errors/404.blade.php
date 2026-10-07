<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Bella Artista</title>
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .error-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 2rem; }
        .error-code { font-family: var(--font-serif); font-size: clamp(4rem, 10vw, 7rem); color: var(--color-gold); line-height: 1; margin-bottom: 1rem; }
        .error-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem; }
    </style>
</head>
<body style="min-height: 100vh; background: var(--bg-dark);">
    <div class="error-page">
        <div>
            <div class="error-code">404</div>
            <h1 style="color: var(--color-cream); margin-bottom: 1rem;">{{ __('errors.notFoundTitle') }}</h1>
            <p style="max-width: 480px; margin: 0 auto;">{{ __('errors.notFoundDesc') }}</p>
            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn-gold">{{ __('errors.homeBtn') }}</a>
                <a href="{{ url('/menu') }}" class="btn-outline">{{ __('errors.menuBtn') }}</a>
            </div>
        </div>
    </div>
</body>
</html>
