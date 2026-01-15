<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionLoghistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_loghistories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisition_id')->constrained('requisitions')->cascadeOnDelete();
            // action_by references employees.id — FK will be added later in a follow-up migration
            $table->unsignedBigInteger('action_by');
            $table->string('action_type', 50);
            $table->text('remarks')->nullable();
            $table->string('previous_status', 50)->nullable();
            $table->string('new_status', 50)->nullable();
            $table->timestamp('action_date')->useCurrent();
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisition_loghistories');
    }
}
