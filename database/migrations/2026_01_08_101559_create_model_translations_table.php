<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_translations', function (Blueprint $table) {
                $table->id();
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->string('language_code', 10);
                $table->string('field_name');
                $table->text('value')->nullable();
                $table->timestamps();
                $table->index(['model_type', 'model_id']);
                $table->index('language_code');
                $table->index(['model_type', 'model_id', 'language_code']);
                // Foreign key constraint for language_code
                $table->foreign('language_code')
                    ->references('code')
                    ->on('languages')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_translations');
    }
}
