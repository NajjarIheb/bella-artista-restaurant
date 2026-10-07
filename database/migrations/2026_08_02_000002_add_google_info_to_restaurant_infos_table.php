<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleInfoToRestaurantInfosTable extends Migration
{
    public function up()
    {
        Schema::table('restaurant_infos', function (Blueprint $table) {
            $table->string('logo_url')->nullable();
            $table->text('about')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->string('plus_code')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('maps_url')->nullable();
            $table->string('place_id')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
        });
    }

    public function down()
    {
        Schema::table('restaurant_infos', function (Blueprint $table) {
            $table->dropColumn([
                'logo_url',
                'about',
                'rating',
                'plus_code',
                'cover_url',
                'maps_url',
                'place_id',
                'latitude',
                'longitude',
            ]);
        });
    }
}
