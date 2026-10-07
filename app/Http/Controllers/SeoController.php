<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $appUrl = rtrim(config('app.url'), '/');

        $content = "User-agent: *\n";
        $content .= "Allow: /\n\n";
        $content .= "Sitemap: {$appUrl}/sitemap.xml\n";

        return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function sitemap(): Response
    {
        $appUrl = rtrim(config('app.url'), '/');

        $pages = [
            ['loc' => '/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => '/menu', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => '/delivery', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => '/reservations', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => '/about', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => '/gallery', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => '/contact', 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$appUrl}{$page['loc']}</loc>\n";
            $xml .= "    <lastmod>" . now()->toDateString() . "</lastmod>\n";
            $xml .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>' . "\n";

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
