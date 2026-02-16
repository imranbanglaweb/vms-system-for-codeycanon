<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // MySQL requires changing enum values via ALTER TABLE
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY charge_bear_by ENUM('Company', 'Employee', 'Vendor', 'Department') DEFAULT 'Company'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE maintenance_requisitions MODIFY charge_bear_by ENUM('Company', 'Employee', 'Vendor') DEFAULT 'Company'");
    }
};
