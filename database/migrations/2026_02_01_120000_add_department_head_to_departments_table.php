<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentHeadToDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            // Add department head employee relationship
            $table->unsignedBigInteger('head_employee_id')->nullable()->after('department_code');
            $table->string('head_email', 150)->nullable()->after('head_employee_id');
            $table->string('head_name', 100)->nullable()->after('head_email');
            
            // Add foreign key constraint
            $table->foreign('head_employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_employee_id']);
            $table->dropColumn(['head_employee_id', 'head_email', 'head_name']);
        });
    }
}
