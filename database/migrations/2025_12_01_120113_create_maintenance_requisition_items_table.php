<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequisitionItemsTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance_requisition_items', function (Blueprint $table) {
            $table->id();

            // Ensure these match parent tables: bigint unsigned
            $table->unsignedBigInteger('requisition_id');
            $table->unsignedBigInteger('category_id');

            $table->string('item_name'); 
            $table->integer('qty')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->tinyInteger('status')->default(1);

            $table->unsignedBigInteger('created_by'); 
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('requisition_id')
                  ->references('id')->on('maintenance_requisitions')
                  ->onDelete('cascade');

            $table->foreign('category_id')
                  ->references('id')->on('maintenance_categories')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_requisition_items');
    }
}

