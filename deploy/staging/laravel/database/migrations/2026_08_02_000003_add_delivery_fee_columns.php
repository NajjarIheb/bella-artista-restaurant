<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryFeeColumns extends Migration
{
    public function up()
    {
        Schema::table('restaurant_infos', function (Blueprint $table) {
            $table->decimal('delivery_fee', 10, 2)->nullable()->after('min_order_amount');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('delivery_fee', 10, 2)->nullable()->after('total_price');
        });

        \Illuminate\Support\Facades\DB::table('restaurant_infos')
            ->whereNull('delivery_fee')
            ->update(['delivery_fee' => 5.00]);
    }

    public function down()
    {
        Schema::table('restaurant_infos', function (Blueprint $table) {
            $table->dropColumn('delivery_fee');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_fee');
        });
    }
}
