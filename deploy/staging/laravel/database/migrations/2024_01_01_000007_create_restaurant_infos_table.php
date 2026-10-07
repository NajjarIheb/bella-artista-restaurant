<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantInfosTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('AURA Fine Dining');
            $table->text('hours')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->json('social_links')->nullable();
            $table->string('delivery_radius')->default('10 km');
            $table->decimal('min_order_amount', 8, 2)->default(30.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_infos');
    }
}
