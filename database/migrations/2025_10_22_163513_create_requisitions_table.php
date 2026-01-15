<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            // requested_by references employees.id — foreign key added later in a follow-up migration
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approved_by_department')->nullable();
            $table->timestamp('department_approved_at')->nullable();
            $table->unsignedBigInteger('transport_admin_id')->nullable();
            $table->timestamp('transport_approved_at')->nullable();
            $table->unsignedBigInteger('vehicle_type')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('from_location');
            $table->string('to_location');
            $table->dateTime('travel_date');
            $table->dateTime('return_date')->nullable();
            //  if (!Schema::hasColumn('requisitions', 'requisition_date')) {
            //     $table->date('requisition_date');
            // }
            // if (!Schema::hasColumn('requisitions', 'number_of_passenger')) {
            //     $table->integer('number_of_passenger')->default(0);
            // }
            $table->text('purpose')->nullable();
            $table->enum('status', ['Pending', 'busy', 'Approved', 'Rejected', 'Completed'])->default('Pending');

            $table->tinyInteger('status_flag')->default(1);
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
        Schema::dropIfExists('requisitions');
    }
}
