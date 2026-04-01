<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpsTracksTable extends Migration
{
    public function up()
    {
        Schema::create('gps_tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('trip_sheet_id')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 6, 2)->nullable()->comment('Speed in km/h');
            $table->decimal('heading', 5, 2)->nullable()->comment('Direction in degrees');
            $table->decimal('altitude', 8, 2)->nullable()->comment('Altitude in meters');
            $table->integer('battery_level')->nullable()->comment('Battery percentage');
            $table->integer('signal_strength')->nullable()->comment('GPS signal strength');
            $table->string('device_id')->nullable()->comment('Mobile device ID');
            $table->string('device_type')->nullable()->comment('Android/iOS');
            $table->string('app_version')->nullable();
            $table->enum('status', ['active', 'idle', 'offline', 'moving'])->default('active');
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
            $table->foreign('trip_sheet_id')->references('id')->on('trip_sheets')->onDelete('set null');

            $table->index(['vehicle_id', 'recorded_at']);
            $table->index(['trip_sheet_id', 'recorded_at']);
            $table->index('device_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gps_tracks');
    }
}