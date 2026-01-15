<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToRequisitionsTable extends Migration
{
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->date('requisition_date')->after('driver_id');
            $table->integer('number_of_passenger')->default(0)->after('return_date');
            
            // Add foreign key for requested_by if not already added
            // $table->foreign('requested_by')->references('id')->on('employees');
        });
    }

    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropColumn(['requisition_date', 'number_of_passenger']);
            $table->dropForeign(['requested_by']);
        });
    }
}