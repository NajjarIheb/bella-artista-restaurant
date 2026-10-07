<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\RestaurantInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportBellaVistaMenu extends Command
{
    protected $signature = 'menu:import-bellavista';

    protected $description = 'Import the Bella Vista menu (from database/data/bellavista_menu.json) into the database.';

    public function handle()
    {
        $path = database_path('data/bellavista_menu.json');
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

        DB::transaction(function () use ($data) {
            MenuItem::query()->delete();
            Category::query()->delete();

            $totalItems = 0;
            foreach ($data['categories'] as $catData) {
                $category = Category::create([
                    'name' => $catData['name'],
                    'display_order' => $catData['display_order'],
                ]);

                foreach ($catData['items'] as $item) {
                    MenuItem::create([
                        'name' => $item['name'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'category_id' => $category->id,
                        'category_name' => $category->name,
                        'image_url' => $item['image_url'],
                        'is_available' => true,
                        'allergens' => null,
                    ]);
                    $totalItems++;
                }
            }

            if (isset($data['store'])) {
                $store = $data['store'];
                RestaurantInfo::updateOrCreate(
                    ['id' => 1],
                    [
                        'name' => $store['name'],
                        'address' => $store['address'] ?? null,
                        'phone' => $store['phone'] ?? null,
                        'social_links' => [
                            'facebook' => $store['facebook'] ?? null,
                            'whatsapp' => $store['whatsapp'] ?? null,
                            'maps' => $store['maps'] ?? null,
                        ],
                    ]
                );
            }

            $this->info("Imported {$totalItems} items across " . count($data['categories']) . ' categories.');
        });

        return 0;
    }
}
