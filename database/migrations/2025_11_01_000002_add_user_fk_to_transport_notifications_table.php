<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserFkToTransportNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add foreign key referencing employees.id. This migration should run after employees table exists.
        if (Schema::hasTable('transport_notifications') && Schema::hasTable('employees')) {
            Schema::table('transport_notifications', function (Blueprint $table) {
                // guard against duplicate key errors
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = null;
                try {
                    $doctrineTable = $sm->listTableDetails('transport_notifications');
                } catch (\Exception $e) {
                    $doctrineTable = null;
                }

                // only add if foreign does not exist
                try {
                    if ($doctrineTable && !$doctrineTable->hasForeignKey('transport_notifications_user_id_foreign')) {
                        $table->foreign('user_id')->references('id')->on('employees')->onDelete('set null');
                    }
                } catch (\Exception $e) {
                    // fallback: try to add without checking
                    try { $table->foreign('user_id')->references('id')->on('employees')->onDelete('set null'); } catch (\Exception $ex) { }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('transport_notifications')) {
            Schema::table('transport_notifications', function (Blueprint $table) {
                // drop foreign if exists
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // ignore
                }
            });
        }
    }
}
