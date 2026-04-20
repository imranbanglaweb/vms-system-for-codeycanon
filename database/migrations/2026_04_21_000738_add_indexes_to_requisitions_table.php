<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            // Indexes for foreign keys
            $table->index('requested_by', 'idx_requisitions_requested_by');
            $table->index('company_id', 'idx_requisitions_company_id');
            $table->index('department_id', 'idx_requisitions_department_id');
            $table->index('vehicle_id', 'idx_requisitions_vehicle_id');
            $table->index('driver_id', 'idx_requisitions_driver_id');
            $table->index('assigned_vehicle_id', 'idx_requisitions_assigned_vehicle_id');
            $table->index('assigned_driver_id', 'idx_requisitions_assigned_driver_id');

            // Indexes for status fields (heavily filtered)
            $table->index('status', 'idx_requisitions_status');
            $table->index('department_status', 'idx_requisitions_department_status');
            $table->index('transport_status', 'idx_requisitions_transport_status');

            // Index for date queries
            $table->index('travel_date', 'idx_requisitions_travel_date');
            $table->index('created_at', 'idx_requisitions_created_at');

            // Composite indexes for common query patterns
            $table->index(['department_status', 'transport_status'], 'idx_requisitions_status_combined');
            $table->index(['requested_by', 'status'], 'idx_requisitions_user_status');
            $table->index(['department_id', 'status'], 'idx_requisitions_dept_status');
        });

        // Add foreign key constraints if they don't exist
        $this->addForeignKeyIfNotExists('requisitions', 'requested_by', 'employees', 'id');
        $this->addForeignKeyIfNotExists('requisitions', 'department_id', 'departments', 'id');
        $this->addForeignKeyIfNotExists('requisitions', 'vehicle_id', 'vehicles', 'id');
        $this->addForeignKeyIfNotExists('requisitions', 'driver_id', 'drivers', 'id');
        $this->addForeignKeyIfNotExists('requisitions', 'assigned_vehicle_id', 'vehicles', 'id');
        $this->addForeignKeyIfNotExists('requisitions', 'assigned_driver_id', 'drivers', 'id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex('idx_requisitions_requested_by');
            $table->dropIndex('idx_requisitions_company_id');
            $table->dropIndex('idx_requisitions_department_id');
            $table->dropIndex('idx_requisitions_vehicle_id');
            $table->dropIndex('idx_requisitions_driver_id');
            $table->dropIndex('idx_requisitions_assigned_vehicle_id');
            $table->dropIndex('idx_requisitions_assigned_driver_id');
            $table->dropIndex('idx_requisitions_status');
            $table->dropIndex('idx_requisitions_department_status');
            $table->dropIndex('idx_requisitions_transport_status');
            $table->dropIndex('idx_requisitions_travel_date');
            $table->dropIndex('idx_requisitions_created_at');
            $table->dropIndex('idx_requisitions_status_combined');
            $table->dropIndex('idx_requisitions_user_status');
            $table->dropIndex('idx_requisitions_dept_status');

            // Drop foreign keys
            $table->dropForeignIfExists(['requested_by']);
            $table->dropForeignIfExists(['department_id']);
            $table->dropForeignIfExists(['vehicle_id']);
            $table->dropForeignIfExists(['driver_id']);
            $table->dropForeignIfExists(['assigned_vehicle_id']);
            $table->dropForeignIfExists(['assigned_driver_id']);
        });
    }

    /**
     * Add foreign key if it doesn't exist (safe check)
     */
    private function addForeignKeyIfNotExists($table, $column, $references, $refColumn)
    {
        try {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys($table);

            $exists = false;
            foreach ($foreignKeys as $fk) {
                if (in_array($column, $fk->getLocalColumns())) {
                    $exists = true;
                    break;
                }
            }

            if (! $exists) {
                DB::statement("ALTER TABLE {$table} ADD CONSTRAINT fk_{$table}_{$column} 
                    FOREIGN KEY ({$column}) REFERENCES {$references}({$refColumn}) ON DELETE SET NULL");
            }
        } catch (\Exception $e) {
            // Doctrine DBAL may not be installed, skip FK checks
        }
    }
};
