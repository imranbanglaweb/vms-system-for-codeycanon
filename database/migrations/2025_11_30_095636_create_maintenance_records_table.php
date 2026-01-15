<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_records', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('schedule_id')->index();
        $table->unsignedBigInteger('vehicle_id')->index();
        $table->unsignedBigInteger('maintenance_type_id')->index();
        $table->unsignedBigInteger('vendor_id')->nullable()->index();
        $table->date('performed_at')->nullable();
        $table->integer('start_km')->nullable();
        $table->integer('end_km')->nullable();
        $table->decimal('cost', 12, 2)->default(0);
        $table->text('notes')->nullable();
        $table->string('receipt_path')->nullable(); // file path
        $table->unsignedBigInteger('performed_by')->nullable(); // user id
                  // Common fields
        $table->tinyInteger('status')->default(1);
        $table->unsignedInteger('created_by');
        $table->unsignedInteger('updated_by')->nullable();
        $table->softDeletes();
        $table->timestamps();
        $table->foreign('schedule_id')->references('id')->on('maintenance_schedules')->onDelete('cascade');
        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        $table->foreign('maintenance_type_id')->references('id')->on('maintenance_types')->onDelete('cascade');
        $table->foreign('vendor_id')->references('id')->on('maintenance_vendors')->onDelete('set null');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_records');
    }
}
