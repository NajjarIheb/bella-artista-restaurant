<?php

namespace App\Console\Commands;

use App\Models\RestaurantInfo;
use Illuminate\Console\Command;

class ImportGoogleInfo extends Command
{
    protected $signature = 'restaurant:import-google-info';

    protected $description = 'Update restaurant info with data scraped from Google Maps (database/data/google_maps_info.json).';

    public function handle()
    {
        $path = database_path('data/google_maps_info.json');
        if (!file_exists($path)) {
            $this->error("Data file not found: {$path}");
            return 1;
        }

        $json = file_get_contents($path);
        if (substr($json, 0, 3) === "\xEF\xBB\xBF") {
            $json = substr($json, 3);
        }

        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON: ' . json_last_error_msg());
            return 1;
        }

        RestaurantInfo::updateOrCreate(['id' => 1], [
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'hours' => $data['hours'],
            'logo_url' => $data['logo_url'],
            'cover_url' => $data['cover_url'],
            'about' => $data['description'],
            'rating' => $data['rating'],
            'plus_code' => $data['plus_code'],
            'maps_url' => $data['maps_url'],
            'place_id' => $data['place_id'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'social_links' => [
                'facebook' => 'https://www.facebook.com/Bella.artiista',
                'whatsapp' => 'https://wa.me/21625258000',
                'maps' => $data['maps_url'],
                'phone_secondary' => $data['phone_secondary'],
            ],
        ]);

        $this->info('Restaurant info updated from Google Maps: ' . $data['name']);

        return 0;
    }
}
