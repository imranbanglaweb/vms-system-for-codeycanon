<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('maintenance_types', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., Service, Oil Change, Tyre Replacement
        $table->text('description')->nullable();
                    // Common fields
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
        //
    }
}
