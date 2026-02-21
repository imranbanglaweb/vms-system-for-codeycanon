<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPendingTransportApprovalStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // MySQL requires modifying ENUM through VARCHAR
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status VARCHAR(50) DEFAULT 'Pending'");
        
        // Add the new status values
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status ENUM('Pending', 'Pending Approval', 'Pending Transport Approval', 'Approved', 'Rejected', 'Completed', 'Cancelled') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to previous enum values
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status VARCHAR(50) DEFAULT 'Pending'");
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY status ENUM('Pending', 'Pending Approval', 'Approved', 'Rejected', 'Completed', 'Cancelled') DEFAULT 'Pending'");
    }
}
