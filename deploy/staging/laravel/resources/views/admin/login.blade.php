<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bella Artista</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--bg-dark);">

    <div class="form-container" style="width: 100%; max-width: 450px;">
        <div style="text-align: center; margin-bottom: 1rem;">
            @if(optional($info)->logo_url)
                <img src="{{ $info->logo_url }}" alt="{{ $info->name ?? 'Bella Artista' }}" style="display: inline-block; width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 1px solid var(--color-border);">
            @else
                <h2 style="color: var(--color-gold); margin: 0;">BELLA ARTISTA</h2>
            @endif
        </div>
        @if(optional($info)->logo_url)
        <h2 style="text-align: center; color: var(--color-gold); margin-bottom: 0.5rem;">{{ $info->name ?? 'BELLA ARTISTA' }}</h2>
        @endif
        <p style="text-align: center; margin-bottom: 2rem; font-size: 0.9rem;">Management Portal Login</p>

        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.4); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <ul style="margin-left: 1.2rem; margin-bottom: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Admin Email</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-gold" style="width: 100%;">Sign In</button>
        </form>
    </div>

</body>
</html>
