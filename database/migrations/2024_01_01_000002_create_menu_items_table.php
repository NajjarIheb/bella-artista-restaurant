<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->string('category_name')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_available')->default(true);
            $table->string('allergens')->nullable(); // e.g. "Gluten, Dairy, Nuts"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
