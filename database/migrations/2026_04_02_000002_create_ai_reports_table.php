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
        Schema::create('ai_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
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
    }
};
