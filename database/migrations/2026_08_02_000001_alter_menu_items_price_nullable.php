<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterMenuItemsPriceNullable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE menu_items MODIFY price DECIMAL(8,2) NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE menu_items MODIFY price DECIMAL(8,2) NOT NULL');
    }
}
