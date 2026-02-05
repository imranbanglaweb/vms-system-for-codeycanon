<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('maintenance_requisitions', function (Blueprint $table) {
            $table->id();

            $table->string('requisition_no')->unique();

            $table->enum('requisition_type', ['scheduled', 'emergency', 'routine','insurance'])->default('scheduled');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Low');

            // You already have tables:
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('maintenance_type_id')->constrained('maintenance_types')->onDelete('cascade');

            $table->date('maintenance_date');

            $table->string('service_title');
            $table->enum('charge_bear_by', ['Company', 'Employee', 'Department'])->default('Company');

            $table->decimal('charge_amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();

            $table->decimal('total_parts_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);

            $table->enum('status', ['Pending', 'Approved', 'Completed', 'Rejected'])->default('Pending');
            $table->unsignedBigInteger('created_by');

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
        Schema::dropIfExists('maintenance_requisitions');
    }
}
