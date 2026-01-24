<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->foreignId('unit_id')->nullable()->constrained('units');
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->string('employee_code', 50)->unique()->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->enum('employee_type', ['Permanent', 'Contract', 'Intern'])->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('nid', 50)->nullable();
            $table->string('photo')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('employees');
    }
}
