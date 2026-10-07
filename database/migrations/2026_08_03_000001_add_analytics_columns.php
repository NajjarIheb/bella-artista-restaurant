<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnalyticsColumns extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_type')->default('delivery')->after('payment_method'); // delivery, dine_in
            $table->foreignId('delivery_zone_id')->nullable()->constrained('delivery_zones')->nullOnDelete()->after('address');
            $table->timestamp('delivered_at')->nullable()->after('status');
            $table->string('cancellation_reason')->nullable()->after('status');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->after('price');
            $table->boolean('is_deal')->default(false)->after('is_available');
            $table->string('deal_group')->nullable()->after('is_deal'); // kids, family, other
        });

        \Illuminate\Support\Facades\DB::table('menu_items')
            ->where('name', 'Kids')
            ->where('category_name', 'Petit Déjeuner')
            ->update(['is_deal' => true, 'deal_group' => 'kids']);
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('delivery_zone_id');
            $table->dropColumn(['order_type', 'delivered_at', 'cancellation_reason']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'is_deal', 'deal_group']);
        });
    }
}
