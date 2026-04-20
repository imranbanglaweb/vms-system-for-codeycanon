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
        Schema::table('requisition_passengers', function (Blueprint $table) {
            // Add index for employee_id (frequently queried)
            $table->index('employee_id', 'idx_requisition_passengers_employee_id');
            // Composite index for common lookup by requisition and employee
            $table->index(['requisition_id', 'employee_id'], 'idx_requisition_passengers_req_emp');
        });

        // Add foreign key constraint if it doesn't exist
        $this->addForeignKeyIfNotExists('requisition_passengers', 'employee_id', 'employees', 'id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisition_passengers', function (Blueprint $table) {
            $table->dropIndex('idx_requisition_passengers_employee_id');
            $table->dropIndex('idx_requisition_passengers_req_emp');
            $table->dropForeignIfExists(['employee_id']);
        });
    }

    /**
     * Add foreign key if it doesn't exist
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
                    FOREIGN KEY ({$column}) REFERENCES {$references}({$refColumn}) ON DELETE CASCADE");
            }
        } catch (\Exception $e) {
            // Doctrine DBAL may not be installed, skip
        }
    }
};
