<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryZonesTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->decimal('delivery_fee', 8, 2)->default(0.00);
            $table->string('estimated_time')->default('30-45 mins');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_zones');
    }
}
