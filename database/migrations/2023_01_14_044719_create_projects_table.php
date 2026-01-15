<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();
            $table->string('project_name',300)->index();
            $table->string('starting_date',300)->index();
            $table->string('ending_date',300)->index();
            $table->string('project_type',500)->index();
            $table->string('project_deadline',300)->index();
            $table->string('project_location')->index();
            $table->string('project_status')->index();
            $table->text('project_description')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('project_oder')->default(1);
            $table->string('remarks',250)->nullable();
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
        Schema::dropIfExists('projects');
    }
}
