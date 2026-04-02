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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_maintenance_alerts');
    }
};
