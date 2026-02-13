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
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->foreignId('trip_id')->nullable()->constrained('requisitions')->onDelete('set null');
            $table->date('fuel_date')->nullable();
            $table->string('fuel_type')->nullable(); // e.g., Petrol, Diesel, CNG
            $table->decimal('quantity', 10, 2)->nullable(); // in liters/gallons
            $table->decimal('cost', 10, 2)->nullable(); // total cost
            $table->string('location')->nullable();
            $table->decimal('odometer_reading', 10, 2)->nullable();
            $table->string('receipt_number')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_logs');
    }
};
