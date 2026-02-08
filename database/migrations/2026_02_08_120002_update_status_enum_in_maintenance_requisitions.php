<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInMaintenanceRequisitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // MySQL doesn't support altering ENUM directly, so we need to drop and recreate
        // First, change the column to VARCHAR temporarily
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status VARCHAR(50) DEFAULT 'Pending'");

        // Now change it back to ENUM with the new values
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status ENUM('Pending', 'Pending Approval', 'Approved', 'Rejected', 'Completed', 'Cancelled') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to original enum
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status VARCHAR(50) DEFAULT 'Pending'");
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status ENUM('Pending', 'Approved', 'Completed', 'Rejected') DEFAULT 'Pending'");
    }
}
