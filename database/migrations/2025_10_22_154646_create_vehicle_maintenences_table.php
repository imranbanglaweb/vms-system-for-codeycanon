<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleMaintenencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_maintenences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->date('maintenance_date');
            $table->string('maintenance_type'); // e.g., Oil Change, Engine Repair, Tire Replacement
            $table->string('service_provider')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('attachment')->nullable(); // optional uploaded file (bill, report, etc.)
            $table->text('remarks')->nullable();
            // Common fields
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Relationships
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_maintenences');
    }
}
