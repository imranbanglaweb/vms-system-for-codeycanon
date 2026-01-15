<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserFkToLogHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('log_histories') && Schema::hasTable('employees')) {
            Schema::table('log_histories', function (Blueprint $table) {
                // add foreign key if not exists
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                try {
                    $doctrineTable = $sm->listTableDetails('log_histories');
                } catch (\Exception $e) {
                    $doctrineTable = null;
                }

                try {
                    if ($doctrineTable && !$doctrineTable->hasForeignKey('log_histories_user_id_foreign')) {
                        $table->foreign('user_id')->references('id')->on('employees')->onDelete('set null');
                    }
                } catch (\Exception $e) {
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
        if (Schema::hasTable('log_histories')) {
            Schema::table('log_histories', function (Blueprint $table) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // ignore
                }
            });
        }
    }
}
