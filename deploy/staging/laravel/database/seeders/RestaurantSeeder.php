<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\DeliveryZone;
use App\Models\RestaurantInfo;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@aura.com'],
            [
                'name' => 'Admin Manager',
                'password' => Hash::make('password123'),
            ]
        );

        // Restaurant Info
        RestaurantInfo::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Bella Artista',
                'hours' => "6:00 AM - 3:00 AM",
                'address' => 'Korba, Tunisia',
                'phone' => '',
                'social_links' => ['instagram' => '#', 'facebook' => '#', 'twitter' => '#'],
                'delivery_radius' => '15 km in-house radius',
                'min_order_amount' => 50.00,
                'delivery_fee' => 5.00,
                'logo_url' => '/storage/restaurant/bella-artista-logo.png',
                'cover_url' => '/storage/restaurant/bella-artista-cover.jpg',
            ]
        );

        // Delivery Zones
        $zones = [
            ['area_name' => 'Downtown & Financial District', 'delivery_fee' => 5.00, 'estimated_time' => '25 - 35 min'],
            ['area_name' => 'Uptown & Harbor Bay', 'delivery_fee' => 8.50, 'estimated_time' => '35 - 50 min'],
            ['area_name' => 'West End Estates', 'delivery_fee' => 12.00, 'estimated_time' => '45 - 60 min'],
        ];

        foreach ($zones as $zone) {
            DeliveryZone::updateOrCreate(['area_name' => $zone['area_name']], $zone);
        }

        // Categories & Menu Items
        $startersCat = Category::create(['name' => 'Starters', 'display_order' => 1]);
        $mainsCat = Category::create(['name' => 'Mains', 'display_order' => 2]);
        $dessertsCat = Category::create(['name' => 'Desserts', 'display_order' => 3]);
        $drinksCat = Category::create(['name' => 'Drinks & Wine', 'display_order' => 4]);

        $menuItems = [
            // Starters
            [
                'name' => 'Truffle & Wild Mushroom Arancini',
                'description' => 'Crispy risotto balls infused with black winter truffle, fontina center, served over aged parmesan cream.',
                'price' => 24.00,
                'category_id' => $startersCat->id,
                'category_name' => 'Starters',
                'image_url' => 'https://images.unsplash.com/photo-1541529086526-db283c563270?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Dairy, Gluten'
            ],
            [
                'name' => 'Seared Hokkaido Scallops',
                'description' => 'Pan-seared scallops, cauliflower silk, crispy prosciutto crumble, and caviar lime reduction.',
                'price' => 32.00,
                'category_id' => $startersCat->id,
                'category_name' => 'Starters',
                'image_url' => 'https://images.unsplash.com/photo-1532550907401-a500c9a57435?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Shellfish, Dairy'
            ],
            [
                'name' => 'Wagyu Beef Carpaccio',
                'description' => 'A5 Japanese Wagyu thinly sliced, caperberries, shaved black truffle, micro arugula, and white truffle oil.',
                'price' => 29.00,
                'category_id' => $startersCat->id,
                'category_name' => 'Starters',
                'image_url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Gluten Free'
            ],

            // Mains
            [
                'name' => 'Prime Dry-Aged Filet Mignon',
                'description' => '45-day dry-aged 8oz center cut beef tenderloin, roasted bone marrow jus, smoked potato puree.',
                'price' => 68.00,
                'category_id' => $mainsCat->id,
                'category_name' => 'Mains',
                'image_url' => 'https://images.unsplash.com/photo-1558030006-450675393462?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Dairy'
            ],
            [
                'name' => 'Pan-Roasted Chilean Sea Bass',
                'description' => 'Wild Chilean sea bass, saffron dashi broth, baby heirloom tomatoes, and braised fennel.',
                'price' => 58.00,
                'category_id' => $mainsCat->id,
                'category_name' => 'Mains',
                'image_url' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Fish'
            ],
            [
                'name' => 'Black Truffle Handmade Tagliolini',
                'description' => 'Fresh handmade egg pasta, Normandy cultured butter, emulsified Parmigiano Reggiano, shaved fresh black truffle.',
                'price' => 46.00,
                'category_id' => $mainsCat->id,
                'category_name' => 'Mains',
                'image_url' => 'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Gluten, Eggs, Dairy'
            ],

            // Desserts
            [
                'name' => 'Dark Chocolate Gold Sphere',
                'description' => 'Valrhona 70% dark chocolate sphere, hazelnut praline mousse, hot salted caramel drizzle.',
                'price' => 18.00,
                'category_id' => $dessertsCat->id,
                'category_name' => 'Desserts',
                'image_url' => 'https://images.unsplash.com/photo-1579372786545-d24232daf58c?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Nuts, Dairy'
            ],
            [
                'name' => 'Deconstructed Madagascar Vanilla Mille-Feuille',
                'description' => 'Caramelized puff pastry leaves, Tahitian vanilla bean diplomat cream, raspberry coulis.',
                'price' => 16.00,
                'category_id' => $dessertsCat->id,
                'category_name' => 'Desserts',
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Dairy, Gluten, Eggs'
            ],

            // Drinks
            [
                'name' => 'Château Margaux Premier Grand Cru (2015)',
                'description' => 'Full-bodied Bordeaux with intense aromas of black currant, violet, and refined oak tannins.',
                'price' => 450.00,
                'category_id' => $drinksCat->id,
                'category_name' => 'Drinks & Wine',
                'image_url' => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Contains Sulfites'
            ],
            [
                'name' => 'Smoked Gold Fashioned Cocktail',
                'description' => 'Japanese Yamazaki 12yr, bitters, organic agave, edible 24k gold leaf, infused with hickory smoke.',
                'price' => 28.00,
                'category_id' => $drinksCat->id,
                'category_name' => 'Drinks & Wine',
                'image_url' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=800&q=80',
                'is_available' => true,
                'allergens' => 'Alcohol'
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }

        // Reviews
        $reviews = [
            ['customer_name' => 'Lord Edward Sterling', 'rating' => 5, 'comment' => 'An absolute culinary triumph. The Wagyu Carpaccio and Filet Mignon were exquisite.', 'date' => now()->subDays(3), 'approved' => true],
            ['customer_name' => 'Victoria Vance', 'rating' => 5, 'comment' => 'The atmosphere, the dark velvet aesthetic, and the wine pairings were perfection.', 'date' => now()->subDays(10), 'approved' => true],
        ];

        foreach ($reviews as $rev) {
            Review::create($rev);
        }
    }
}
