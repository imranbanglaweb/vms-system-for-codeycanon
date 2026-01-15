<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('maintenance_schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vehicle_id')->index();
        $table->string('title')->nullable();
        $table->unsignedBigInteger('maintenance_type_id')->index();
        $table->unsignedBigInteger('vendor_id')->nullable()->index();
        $table->date('next_due_date')->nullable();
        $table->date('scheduled_at');
        $table->integer('due_km')->nullable(); // optional: next km to trigger
        $table->string('frequency')->nullable(); // e.g., '3 months', '6 months', 'monthly', or JSON
        $table->text('notes')->nullable();
        $table->boolean('active')->default(true);
        
        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        $table->foreign('maintenance_type_id')->references('id')->on('maintenance_types')->onDelete('cascade');
        $table->foreign('vendor_id')->references('id')->on('maintenance_vendors')->onDelete('set null');
        // Common fields
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
        Schema::dropIfExists('maintenance_schedules');
    }
}
