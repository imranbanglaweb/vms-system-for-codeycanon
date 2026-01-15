<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
        $table->enum('department_status', ['Pending',  'busy', 'Assigned', 'Approved', 'Rejected'])
                ->default('Pending');
          $table->enum('transport_status', ['Pending', 'busy', 'Assigned', 'Approved', 'Rejected'])
                ->default('Pending');
            $table->unsignedBigInteger('assigned_vehicle_id')->nullable();
            $table->unsignedBigInteger('assigned_driver_id')->nullable();
            $table->text('transport_remarks')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
        });
    }
}
