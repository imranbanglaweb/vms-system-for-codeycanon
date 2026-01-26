<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();

            // Driver Details
            $table->string('driver_name');
            $table->string('license_number')->unique()->nullable();
            $table->string('nid')->nullable();
            $table->string('employee_nid')->nullable();
            $table->string('license_type')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('joining_date')->nullable();

            // Address & Contact
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('mobile')->nullable();

            // Work & Leave
            $table->string('working_time_slot')->nullable();
            $table->boolean('leave_status')->default(0);

            // Media
            $table->string('photograph')->nullable();

            // Common Fields
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
        Schema::dropIfExists('drivers');
    }
}
