<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');                // Starter, Business, Enterprise
        $table->string('code')->unique();       // starter, business
        $table->decimal('price', 10, 2);
        $table->enum('billing_cycle',['monthly','yearly']);
        $table->integer('max_users')->nullable();
        $table->integer('max_vehicles')->nullable();
        $table->boolean('maintenance')->default(true);
        $table->boolean('fuel')->default(true);
        $table->boolean('reports')->default(true);
        $table->boolean('push_notification')->default(true);
        $table->boolean('api_access')->default(false);
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
        Schema::dropIfExists('plans');
    }
}
