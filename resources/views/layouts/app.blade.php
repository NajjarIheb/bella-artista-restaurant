@php
    $seoName = $siteInfo->name ?? 'Bella Artista';
    $seoBaseUrl = rtrim(config('app.url'), '/');
    $seoPath = '/' . ltrim(request()->path(), '/');
    if ($seoPath !== '/') {
        $seoPath = rtrim($seoPath, '/');
    }
    $seoCanonical = $seoBaseUrl . $seoPath;
    $seoImage = $siteInfo->logo_url ? url($siteInfo->logo_url) : '';
    $seoDefaultTitle = $seoName . ' - ' . __('seo.tagline');
    $seoDefaultDesc = __('seo.defaultDescription');
    $seoCompact = function ($a) { return array_filter($a, function ($v) { return $v !== null && $v !== ''; }); };
    $seoJsonLd = [
        '@context' => 'https://schema.org',
        '@graph' => [
            $seoCompact([
                '@type' => 'Restaurant',
                '@id' => $seoBaseUrl . '/#organization',
                'name' => $seoName,
                'url' => $seoBaseUrl,
                'logo' => $seoImage,
                'image' => $seoImage,
                'telephone' => $siteInfo->phone ?? null,
                'address' => $seoCompact([
                    '@type' => 'PostalAddress',
                    'streetAddress' => $siteInfo->address ?? null,
                ]),
                'servesCuisine' => __('seo.cuisine'),
            ]),
            $seoCompact([
                '@type' => 'WebSite',
                '@id' => $seoBaseUrl . '/#website',
                'url' => $seoBaseUrl,
                'name' => $seoName,
            ]),
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $seoDefaultTitle)</title>
    <meta name="description" content="@yield('metaDescription', $seoDefaultDesc)">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $seoCanonical }}">
    @if(config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
    @endif
    <meta property="og:site_name" content="{{ $seoName }}">
    <meta property="og:title" content="@yield('title', $seoDefaultTitle)">
    <meta property="og:description" content="@yield('metaDescription', $seoDefaultDesc)">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:type" content="@yield('ogType', 'website')">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seoDefaultTitle)">
    <meta name="twitter:description" content="@yield('metaDescription', $seoDefaultDesc)">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="application/ld+json">{!! json_encode($seoJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @yield('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-logo">
                @if(optional($siteInfo)->logo_url)
                    <img src="{{ $siteInfo->logo_url }}" alt="{{ $siteInfo->name }}" class="site-logo">
                @else
                    BELLA <span>ARTISTA</span>
                @endif
            </a>
            
            <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('nav.home') }}</a></li>
                    <li><a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}">{{ __('nav.menu') }}</a></li>
                    <li><a href="{{ route('delivery') }}" class="{{ request()->routeIs('delivery') ? 'active' : '' }}">{{ __('nav.delivery') }}</a></li>
                    <li><a href="{{ route('reservations') }}" class="{{ request()->routeIs('reservations') ? 'active' : '' }}">{{ __('nav.reservations') }}</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('nav.about') }}</a></li>
                    <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">{{ __('nav.gallery') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('nav.contact') }}</a></li>
                </ul>

                <div class="nav-actions">
                    <div class="lang-dd" id="langDropdown">
                        <button type="button" class="lang-dd__toggle" aria-label="{{ __('lang.select') }}" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe lang-dd__globe"></i>
                            <span class="lang-dd__code">{{ strtoupper(app()->getLocale()) }}</span>
                            <i class="fas fa-chevron-down lang-dd__caret"></i>
                        </button>
                        <div class="lang-dd__menu" id="langMenu">
                            <div class="lang-dd__label">{{ __('lang.select') }}</div>
                            @foreach(['fr', 'en', 'ar'] as $l)
                            @if(app()->getLocale() !== $l)
                            <a href="{{ route('lang.switch', $l) }}" class="lang-dd__opt">
                                <span class="lang-dd__opt-code">{{ strtoupper($l) }}</span>
                                <span class="lang-dd__opt-name">{{ __("lang.$l") }}</span>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    @auth
                    @php
                        $notifList = \App\Models\CustomerNotification::where('user_id', Auth::id())->orderByDesc('id')->limit(5)->get();
                        $notifUnread = \App\Models\CustomerNotification::where('user_id', Auth::id())->whereNull('read_at')->count();
                    @endphp
                    <div class="lang-dd" id="notifDropdown">
                        <button type="button" class="lang-dd__toggle" aria-haspopup="true" aria-expanded="false" aria-label="{{ __('nav.notifications') }}" style="position: relative;">
                            <i class="fas fa-bell lang-dd__globe"></i>
                            @if($notifUnread > 0)
                                <span style="position: absolute; top: -2px; right: -2px; background: var(--color-gold); color: #0d0d10; border-radius: 999px; min-width: 16px; height: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700; padding: 0 4px;">{{ $notifUnread > 9 ? '9+' : $notifUnread }}</span>
                            @endif
                        </button>
                        <div class="lang-dd__menu" id="notifMenu" style="width: 320px; max-width: calc(100vw - 2rem);">
                            <div class="lang-dd__label">{{ __('nav.notifications') }}</div>
                            @forelse($notifList as $notif)
                                <a href="{{ route('customer.notifications.open', $notif->id) }}" class="lang-dd__opt" style="align-items: flex-start; padding-block: 0.7rem;">
                                    <span class="lang-dd__opt-code">
                                        @if($notif->type == 'orderConfirmed')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($notif->type == 'orderOutForDelivery')
                                            <i class="fas fa-truck-moving"></i>
                                        @elseif($notif->type == 'orderDelivered')
                                            <i class="fas fa-check-double"></i>
                                        @else
                                            <i class="fas fa-times-circle"></i>
                                        @endif
                                    </span>
                                    <span class="lang-dd__opt-name" style="display: flex; flex-direction: column; gap: 0.2rem;">
                                        <span style="font-weight: {{ $notif->read_at ? '400' : '700' }};">{{ __("notif." . $notif->type, ['id' => $notif->order_id]) }}</span>
                                        <span style="font-size: 0.72rem; color: var(--color-text-muted); font-weight: 400;">{{ $notif->created_at->diffForHumans() }}</span>
                                    </span>
                                </a>
                            @empty
                                <div class="lang-dd__opt" style="color: var(--color-text-muted); font-size: 0.85rem; justify-content: center;">{{ __('notif.empty') }}</div>
                            @endforelse
                            <div style="display: flex; gap: 0.4rem; padding: 0.6rem 0.8rem; border-top: 1px solid var(--color-border);">
                                <a href="{{ route('customer.notifications') }}" class="btn-gold" style="flex: 1; text-align: center; font-size: 0.8rem; padding: 0.45rem;">{{ __('notif.viewAll') }}</a>
                                @if($notifUnread > 0)
                                <form action="{{ route('customer.notifications.readAll') }}" method="POST" style="margin: 0; flex: 1;">
                                    @csrf
                                    <button type="submit" class="btn-gold" style="width: 100%; font-size: 0.8rem; padding: 0.45rem; background: transparent; border: 1px solid var(--color-gold); color: var(--color-gold);">{{ __('notif.markAllRead') }}</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="lang-dd" id="accountDropdown">
                        <button type="button" class="lang-dd__toggle" aria-haspopup="true" aria-expanded="false" style="gap: 0.4rem;">
                            <i class="fas fa-user lang-dd__globe"></i>
                            <span class="lang-dd__code">{{ Str::limit(Auth::user()->name, 12, 'â€¦') }}</span>
                            <i class="fas fa-chevron-down lang-dd__caret"></i>
                        </button>
                        <div class="lang-dd__menu" id="accountMenu">
                            <div class="lang-dd__label">{{ __('nav.account') }}</div>
                            <a href="{{ route('customer.orders') }}" class="lang-dd__opt">
                                <span class="lang-dd__opt-code"><i class="fas fa-receipt"></i></span>
                                <span class="lang-dd__opt-name">{{ __('nav.myOrders') }}</span>
                            </a>
                            <a href="{{ route('track.order') }}" class="lang-dd__opt">
                                <span class="lang-dd__opt-code"><i class="fas fa-truck-moving"></i></span>
                                <span class="lang-dd__opt-name">{{ __('nav.trackOrder') }}</span>
                            </a>
                            <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="lang-dd__opt" style="width: 100%; border: none; background: none; text-align: start;">
                                    <span class="lang-dd__opt-code"><i class="fas fa-sign-out-alt"></i></span>
                                    <span class="lang-dd__opt-name">{{ __('nav.logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('customer.login') }}" class="btn-gold nav-book-btn" style="background: transparent; border: 1px solid var(--color-gold); color: var(--color-gold);">
                        <i class="fas fa-user" style="margin-inline-end: 6px;"></i> {{ __('nav.login') }}
                    </a>
                    @endauth

                    <a href="{{ route('delivery') }}" class="btn-gold nav-cart-btn">
                        <i class="fas fa-shopping-cart"></i> {{ __('nav.cart') }} <span class="cart-badge" style="display: none; background: #fff; color: #0d0d10; border-radius: 999px; min-width: 18px; height: 18px; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; padding: 0 4px;">0</span>
                    </a>
                    <a href="{{ route('reservations') }}" class="btn-gold nav-book-btn">{{ __('nav.bookTable') }}</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <a href="{{ route('home') }}" class="nav-logo" style="margin-bottom: 1rem; display: inline-block;">
                    @if(optional($siteInfo)->logo_url)
                        <img src="{{ $siteInfo->logo_url }}" alt="{{ $siteInfo->name }}" class="site-logo">
                    @else
                        BELLA <span>ARTISTA</span>
                    @endif
                </a>
                <p>{{ $siteInfo->about ?? __('footer.about') }}</p>
            </div>
            
            <div class="footer-col">
                <h4>{{ __('footer.hoursLocation') }}</h4>
                <p><i class="fas fa-map-marker-alt text-gold" style="margin-right: 8px;"></i> {{ $siteInfo->address ?? __('contact.addressFallback') }}</p>
                <p><i class="fas fa-clock text-gold" style="margin-right: 8px;"></i> {{ $siteInfo->hours ?? __('footer.openDaily') }}</p>
                <p><i class="fas fa-phone text-gold" style="margin-right: 8px;"></i> {{ $siteInfo->phone ?? '' }}</p>
            </div>

            <div class="footer-col">
                <h4>{{ __('footer.inHouseDelivery') }}</h4>
                <p>{{ __('footer.weDeliverDirectly') }}</p>
                <p><strong class="text-gold">{{ __('footer.paymentOptions') }}</strong></p>
                <p><a href="{{ route('track.order') }}" class="text-gold" style="text-decoration: underline;"><i class="fas fa-truck-moving" style="margin-inline-end: 6px;"></i>{{ __('nav.trackOrder') }}</a></p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $siteInfo->name ?? 'Bella Artista' }}. {{ __('footer.allRightsReserved') }} | <a href="{{ route('admin.login') }}" class="text-gold">{{ __('footer.adminPortal') }}</a></p>
        </div>
    </footer>

    <script>
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

        function positionDrawer() {
            const bar = document.querySelector('header.navbar');
            if (!navMenu) return;
            if (window.innerWidth <= 850 && bar) {
                const h = bar.offsetHeight;
                navMenu.style.top = h + 'px';
                navMenu.style.height = 'calc(100vh - ' + h + 'px)';
            } else {
                navMenu.style.top = '';
                navMenu.style.height = '';
            }
        }
        window.addEventListener('resize', positionDrawer);
        positionDrawer();

        const langToggle = document.querySelector('.lang-dd__toggle');
        const langMenu = document.querySelector('.lang-dd__menu');
        if (langToggle && langMenu) {
            langToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = langMenu.classList.toggle('open');
                langToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            document.addEventListener('click', (e) => {
                if (!document.getElementById('langDropdown').contains(e.target)) {
                    langMenu.classList.remove('open');
                    langToggle.setAttribute('aria-expanded', 'false');
                }
            });
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    langMenu.classList.remove('open');
                    langToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        const accountToggle = document.getElementById('accountDropdown')?.querySelector('.lang-dd__toggle');
        const accountMenu = document.getElementById('accountMenu');
        if (accountToggle && accountMenu) {
            accountToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = accountMenu.classList.toggle('open');
                accountToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            document.addEventListener('click', (e) => {
                const dd = document.getElementById('accountDropdown');
                if (dd && !dd.contains(e.target)) {
                    accountMenu.classList.remove('open');
                    accountToggle.setAttribute('aria-expanded', 'false');
                }
            });
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    accountMenu.classList.remove('open');
                    accountToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
        const notifToggle = document.getElementById('notifDropdown')?.querySelector('.lang-dd__toggle');
        const notifMenu = document.getElementById('notifMenu');
        if (notifToggle && notifMenu) {
            notifToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = notifMenu.classList.toggle('open');
                notifToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            document.addEventListener('click', (e) => {
                const dd = document.getElementById('notifDropdown');
                if (dd && !dd.contains(e.target)) {
                    notifMenu.classList.remove('open');
                    notifToggle.setAttribute('aria-expanded', 'false');
                }
            });
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    notifMenu.classList.remove('open');
                    notifToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    </script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @yield('scripts')
</body>
</html>
