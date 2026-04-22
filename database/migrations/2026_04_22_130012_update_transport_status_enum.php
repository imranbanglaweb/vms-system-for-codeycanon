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
        DB::statement("ALTER TABLE requisitions MODIFY transport_status ENUM('Pending', 'Approved', 'Rejected', 'In Transit', 'Assigned', 'Trip Completed', 'Completed') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE requisitions MODIFY transport_status ENUM('Pending', 'Approved', 'Rejected', 'Assigned', 'busy') DEFAULT 'Pending'");
    }
};
