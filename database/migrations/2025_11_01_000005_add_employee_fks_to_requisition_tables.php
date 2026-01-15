<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeFksToRequisitionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use Doctrine to check existing foreign keys/indexes before adding to avoid
        // duplicate key errors (errno 121) when running migrations on DBs that
        // may already contain indexes with the same name.
        $sm = Schema::getConnection()->getDoctrineSchemaManager();

        if (Schema::hasTable('requisition_passengers') && Schema::hasTable('employees')) {
            try {
                $doctrineTable = $sm->listTableDetails('requisition_passengers');
            } catch (\Exception $e) {
                $doctrineTable = null;
            }

            if (!$doctrineTable || !$doctrineTable->hasForeignKey('requisition_passengers_employee_id_foreign')) {
                Schema::table('requisition_passengers', function (Blueprint $table) {
                    try {
                        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
                    } catch (\Exception $e) { /* ignore if cannot add */ }
                });
            }
        }

        if (Schema::hasTable('requisition_approvals') && Schema::hasTable('employees')) {
            try {
                $doctrineTable = $sm->listTableDetails('requisition_approvals');
            } catch (\Exception $e) {
                $doctrineTable = null;
            }

            if (!$doctrineTable || !$doctrineTable->hasForeignKey('requisition_approvals_approved_by_foreign')) {
                Schema::table('requisition_approvals', function (Blueprint $table) {
                    try {
                        $table->foreign('approved_by')->references('id')->on('employees')->onDelete('set null');
                    } catch (\Exception $e) { }
                });
            }
        }

        if (Schema::hasTable('requisition_loghistories') && Schema::hasTable('employees')) {
            try {
                $doctrineTable = $sm->listTableDetails('requisition_loghistories');
            } catch (\Exception $e) {
                $doctrineTable = null;
            }

            if (!$doctrineTable || !$doctrineTable->hasForeignKey('requisition_loghistories_action_by_foreign')) {
                Schema::table('requisition_loghistories', function (Blueprint $table) {
                    try {
                        $table->foreign('action_by')->references('id')->on('employees')->onDelete('set null');
                    } catch (\Exception $e) { }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('requisition_passengers')) {
            Schema::table('requisition_passengers', function (Blueprint $table) {
                try { $table->dropForeign(['employee_id']); } catch (\Exception $e) { }
            });
        }

        if (Schema::hasTable('requisition_approvals')) {
            Schema::table('requisition_approvals', function (Blueprint $table) {
                try { $table->dropForeign(['approved_by']); } catch (\Exception $e) { }
            });
        }

        if (Schema::hasTable('requisition_loghistories')) {
            Schema::table('requisition_loghistories', function (Blueprint $table) {
                try { $table->dropForeign(['action_by']); } catch (\Exception $e) { }
            });
        }
    }
}
