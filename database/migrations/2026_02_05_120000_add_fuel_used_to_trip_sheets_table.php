<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFuelUsedToTripSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_sheets', function (Blueprint $table) {
            $table->decimal('fuel_used', 10, 2)->nullable()->after('total_km');
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
            $table->dropColumn(['fuel_used']);
        });
    }
}
