<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('maintenance_requisitions', function (Blueprint $table) {
            $table->enum('department_status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('status');
            $table->unsignedBigInteger('department_approved_by')->nullable()->after('department_status');
            $table->timestamp('department_approved_at')->nullable()->after('department_approved_by');
            $table->text('department_remarks')->nullable()->after('department_approved_at');
            $table->enum('transport_status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('department_remarks');
            $table->unsignedBigInteger('transport_approved_by')->nullable()->after('transport_status');
            $table->timestamp('transport_approved_at')->nullable()->after('transport_approved_by');
            $table->text('transport_remarks')->nullable()->after('transport_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requisitions', function (Blueprint $table) {
            $table->dropColumn([
                'department_status',
                'department_approved_by',
                'department_approved_at',
                'department_remarks',
                'transport_status',
                'transport_approved_by',
                'transport_approved_at',
                'transport_remarks',
            ]);
        });
    }
};
