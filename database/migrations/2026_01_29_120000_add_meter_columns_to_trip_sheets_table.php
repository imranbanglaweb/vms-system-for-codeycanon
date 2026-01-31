<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeterColumnsToTripSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_sheets', function (Blueprint $table) {
            $table->decimal('start_meter', 10, 2)->nullable()->after('trip_start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trip_sheets', function (Blueprint $table) {
            $table->dropColumn(['start_meter']);
        });
    }
}
