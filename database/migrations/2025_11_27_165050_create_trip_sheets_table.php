<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('trip_sheets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('requisition_id');
        $table->unsignedBigInteger('vehicle_id');
        $table->unsignedBigInteger('driver_id');

        $table->dateTime('trip_start_time')->nullable();
        $table->dateTime('trip_end_time')->nullable();

        $table->string('start_location')->nullable();
        $table->string('end_location')->nullable();
        $table->string('distance')->nullable();

        $table->integer('start_km')->nullable();
        $table->integer('end_km')->nullable();
        $table->integer('total_km')->nullable();

        $table->text('remarks')->nullable();
        $table->string('status')->default('in_progress'); // in_progress, finished

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
        Schema::dropIfExists('trip_sheets');
    }
}
