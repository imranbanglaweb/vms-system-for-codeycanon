<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            // First check if columns exist before adding
            if (!Schema::hasColumn('requisitions', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('id');
            }
            
            // Add unit_id first since requisition_number depends on it
            if (!Schema::hasColumn('requisitions', 'unit_id')) {
                $table->string('unit_id')->after('department_id');
            }
            
            // Then add requisition_number after unit_id
            if (!Schema::hasColumn('requisitions', 'requisition_number')) {
                $table->string('requisition_number')->unique()->after('unit_id');
            }
            
            // Finally add description
            if (!Schema::hasColumn('requisitions', 'description')) {
                $table->text('description')->nullable()->after('unit_id');
            }
        });
    }

    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            // Drop columns in reverse order
            $columnsToDrop = ['description', 'requisition_number', 'unit_id', 'department_id'];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('requisitions', $column)) {
                    // Drop foreign key for department_id if it exists
                    if ($column === 'department_id') {
                        // Check if foreign key exists
                        $connection = Schema::getConnection();
                        $dbSchemaManager = $connection->getDoctrineSchemaManager();
                        $foreignKeys = $dbSchemaManager->listTableForeignKeys($table->getTable());
                        
                        $hasForeignKey = false;
                        foreach ($foreignKeys as $foreignKey) {
                            if (in_array('department_id', $foreignKey->getLocalColumns())) {
                                $hasForeignKey = true;
                                break;
                            }
                        }
                        
                        if ($hasForeignKey) {
                            $table->dropForeign(['department_id']);
                        }
                    }
                    
                    $table->dropColumn($column);
                }
            }
        });
    }
}