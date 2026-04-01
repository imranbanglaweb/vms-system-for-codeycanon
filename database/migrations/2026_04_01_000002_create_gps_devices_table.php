<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gps_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->string('device_name');
            $table->string('device_type')->nullable(); // e.g., 'GT06N', 'TK103', 'A8', 'Syrus', etc.
            $table->string('imei_number')->unique();
            $table->string('sim_number')->nullable();
            $table->string('protocol')->default('GT06'); // GT06, TK103, A8, Syrus, custom, etc.
            $table->string('server_host')->nullable(); // IP or hostname for device to send data
            $table->integer('server_port')->nullable(); // Port number
            $table->boolean('is_active')->default(true);
            $table->date('installation_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('vehicle_id');
            $table->index('imei_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gps_devices');
    }
};