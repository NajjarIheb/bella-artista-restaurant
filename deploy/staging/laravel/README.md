<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## SEO & Production Readiness

### Google Search Console verification
Add your verification code to `.env` and it will be rendered inside `<head>` of every page:

```
GOOGLE_SITE_VERIFICATION=your-code-here
```

### robots.txt
Served dynamically at `/robots.txt` (`app/Http/Controllers/SeoController.php`).
- Allows all search engines (`User-agent: *` / `Allow: /`)
- References the sitemap: `Sitemap: <APP_URL>/sitemap.xml`
- URLs are built from `APP_URL` (no hardcoded domains)

### XML sitemap
Served automatically at `/sitemap.xml` and lists all public pages: home, menu,
delivery, reservations, about, gallery and contact. Each URL is generated from
`APP_URL` with `lastmod`, `changefreq` and `priority`.

### Per-page SEO meta tags
`resources/views/layouts/app.blade.php` outputs for every page:
- Unique `<title>` (each page sets its own via `@section('title')`)
- `meta description` (per-page via `@section('metaDescription')`, with localized defaults in `resources/lang/*.json` under the `seo.*` keys)
- Canonical URL (built from `APP_URL` + current path)
- Open Graph tags: `og:site_name`, `og:title`, `og:description`, `og:url`, `og:type`, `og:image`
- Twitter Card tags: `summary_large_image`, `twitter:title`, `twitter:description`, `twitter:image`
- `robots` meta `index, follow` on all public pages (nothing blocks crawling)

### Structured data
JSON-LD (`Schema.org`) is injected on every page via the layout, using
`Restaurant` and `WebSite` entities with the restaurant name, URL, logo,
phone, address and cuisine.

### Headings & accessibility
- One `<h1>` per page (home hero, and each public page's section header)
- Semantic landmarks: `<header>`, `<main>`, `<footer>` in the layout
- All images carry meaningful `alt` attributes; below-the-fold images use `loading="lazy"`

### Error pages
Custom, self-contained views in `resources/views/errors/`:
- `404.blade.php` — returns HTTP 404 (noindex)
- `500.blade.php` — returns HTTP 500 (noindex)
- They do not depend on the database, so they render even when the app is failing.

