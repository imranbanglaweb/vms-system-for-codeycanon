<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestedByFkToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('requisitions') && Schema::hasTable('employees')) {
            Schema::table('requisitions', function (Blueprint $table) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                try {
                    $doctrineTable = $sm->listTableDetails('requisitions');
                } catch (\Exception $e) {
                    $doctrineTable = null;
                }

                try {
                    if ($doctrineTable && !$doctrineTable->hasForeignKey('requisitions_requested_by_foreign')) {
                        $table->foreign('requested_by')->references('id')->on('employees')->onDelete('cascade');
                    }
                } catch (\Exception $e) {
                    try { $table->foreign('requested_by')->references('id')->on('employees')->onDelete('cascade'); } catch (\Exception $ex) { }
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
        if (Schema::hasTable('requisitions')) {
            Schema::table('requisitions', function (Blueprint $table) {
                try {
                    $table->dropForeign(['requested_by']);
                } catch (\Exception $e) {
                    // ignore
                }
            });
        }
    }
}
