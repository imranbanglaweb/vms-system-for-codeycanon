<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('menu_parent')->default(0);
            $table->string('menu_name', 150);
            $table->string('menu_slug', 100);
            $table->string('menu_type', 100)->nullable();
            $table->string('menu_location', 100)->nullable();
            $table->string('remarks', 250)->nullable();
            $table->string('menu_icon', 300)->nullable();
            $table->string('menu_color', 100)->nullable();
            $table->string('menu_url', 250)->nullable();
            $table->string('menu_permission')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('menu_order')->default(0); // REMOVED: after `parent_id`
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('menus');
    }
}
