<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->string('category_name',150)->index();
            $table->string('category_slug',100)->index();
            $table->string('category_type',100)->nullable();
            $table->integer('category_oder')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Add foreign key to inventory_items here since this migration runs after inventory_items
        if (Schema::hasTable('inventory_items')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                $table->foreign('category_id')
                    ->references('id')
                    ->on('maintenance_categories')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the foreign key before dropping the parent table
        if (Schema::hasTable('inventory_items')) {
            Schema::table('inventory_items', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }
        Schema::dropIfExists('maintenance_categories');
    }
}
