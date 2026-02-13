<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAssignedToVehiclesAvailabilityStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add 'assigned' as a new enum value for availability_status
        DB::statement("ALTER TABLE vehicles MODIFY availability_status ENUM('available', 'busy', 'maintenance', 'on_leave', 'assigned') DEFAULT 'available'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove 'assigned' from enum
        DB::statement("ALTER TABLE vehicles MODIFY availability_status ENUM('available', 'busy', 'maintenance', 'on_leave') DEFAULT 'available'");
    }
}
