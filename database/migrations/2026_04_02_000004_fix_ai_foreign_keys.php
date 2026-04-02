<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        // Drop existing tables with incorrect foreign keys if they exist
        Schema::dropIfExists('ai_reports');
        Schema::dropIfExists('ai_maintenance_alerts');
        
        // Recreate ai_maintenance_alerts with correct foreign key
        Schema::create('ai_maintenance_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->enum('alert_type', ['oil_change', 'tire_replacement', 'brake_service', 'battery', 'filter', 'transmission', 'suspension', 'other']);
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['pending', 'acknowledged', 'scheduled', 'completed', 'dismissed'])->default('pending');
            $table->text('recommendation');
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->integer('urgency_level')->default(1); // 1-5 scale
            $table->json('ai_analysis')->nullable(); // Store full AI response
            $table->text('notes')->nullable();
            $table->dateTime('scheduled_date')->nullable();
            $table->string('company_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['vehicle_id', 'status']);
            $table->index(['priority', 'status']);
            $table->index(['created_at']);
        });

        // Recreate ai_reports with correct foreign key
        Schema::create('ai_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->enum('report_type', ['maintenance', 'fuel_efficiency', 'driver_performance', 'fleet_health', 'cost_analysis', 'custom']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['generating', 'completed', 'failed', 'archived'])->default('generating');
            $table->dateTime('report_period_from')->nullable();
            $table->dateTime('report_period_to')->nullable();
            $table->json('filter_criteria')->nullable(); // e.g., vehicle_ids, departments, etc.
            $table->json('ai_summary')->nullable(); // Executive summary from AI
            $table->json('ai_findings')->nullable(); // Key findings from AI
            $table->json('ai_recommendations')->nullable(); // Recommendations from AI
            $table->json('ai_analysis')->nullable(); // Full AI analysis
            $table->json('raw_data')->nullable(); // Original data used for analysis
            $table->text('error_message')->nullable(); // If failed
            $table->string('file_path')->nullable(); // Path to generated PDF/Excel report
            $table->integer('total_records')->default(0);
            $table->string('company_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['report_type', 'status']);
            $table->index(['created_by']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_reports');
        Schema::dropIfExists('ai_maintenance_alerts');
    }
};
