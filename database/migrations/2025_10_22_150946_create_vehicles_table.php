<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('vehicle_number', 100);
            $table->string('vehicle_name', 100)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('license_plate', 50)->unique()->nullable();
            $table->string('alert_cell_number', 20)->nullable();
            $table->enum('ownership', ['Owned', 'Rented', 'Leased'])->nullable();

            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();

            $table->unsignedInteger('seat_capacity')->nullable();
            $table->tinyInteger('status')->default(1);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->nullOnDelete();
            $table->foreign('driver_id')->references('id')->on('drivers')->nullOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->nullOnDelete();
        });


    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['vehicle_type_id']);
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['vendor_id']);
        });
        Schema::dropIfExists('vehicles');
    }
}
