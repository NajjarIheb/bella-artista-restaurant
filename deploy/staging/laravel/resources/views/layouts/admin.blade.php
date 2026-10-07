<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Bella Artista')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-sidebar {
            width: 250px;
            background: var(--bg-card);
            border-right: 1px solid var(--color-border);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 2rem 1.5rem;
        }

        .admin-main {
            margin-left: 250px;
            padding: 3rem 2.5rem;
            min-height: 100vh;
        }

        .admin-nav-item {
            display: block;
            padding: 0.9rem 1.2rem;
            color: var(--color-text-muted);
            border-radius: 4px;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .admin-nav-item:hover, .admin-nav-item.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--color-gold);
        }

        @media (max-width: 850px) {
            .admin-sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
            }
            .admin-main {
                margin-left: 0;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body style="background-color: #0d0d10;">

    <div class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" style="display: block; margin-bottom: 2rem;">
            <img src="/storage/restaurant/bella-artista-logo.png" alt="Bella Artista" style="max-width: 100%; max-height: 70px; object-fit: contain; display: block; margin: 0 auto;">
        </a>
        
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line" style="width: 25px;"></i> Dashboard
        </a>
        <a href="{{ route('admin.orders') }}" class="admin-nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag" style="width: 25px;"></i> Delivery Orders
        </a>
        <a href="{{ route('admin.reservations') }}" class="admin-nav-item {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
            <i class="fas fa-calendar-check" style="width: 25px;"></i> Reservations
        </a>
        <a href="{{ route('admin.analytics') }}" class="admin-nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar" style="width: 25px;"></i> Analytics
        </a>
        <a href="{{ route('admin.menu') }}" class="admin-nav-item {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
            <i class="fas fa-utensils" style="width: 25px;"></i> Menu Items
        </a>
        <a href="{{ route('admin.settings') }}" class="admin-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="fas fa-cog" style="width: 25px;"></i> Settings
        </a>
        <a href="{{ route('home') }}" target="_blank" class="admin-nav-item">
            <i class="fas fa-external-link-alt" style="width: 25px;"></i> View Website
        </a>

        <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 3rem;">
            @csrf
            <button type="submit" class="btn-outline" style="width: 100%; padding: 0.6rem; font-size: 0.85rem;">Logout</button>
        </form>
    </div>

    <div class="admin-main">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    @yield('scripts')

</body>
</html>
