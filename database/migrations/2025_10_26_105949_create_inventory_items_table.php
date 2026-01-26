<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock_qty')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);

            // Correct foreign key
            $table->unsignedBigInteger('category_id')->nullable();
            // Foreign key constraint moved to 2025_11_01_123055_create_maintenance_categories_table.php to resolve dependency order

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}
