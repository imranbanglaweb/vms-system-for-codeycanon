<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageSettingsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('default_language', 10)->default('en')->after('admin_logo');
            $table->json('available_languages')->default('["en"]')->after('default_language');
            $table->boolean('auto_translate')->default(false)->after('available_languages');
            $table->integer('translation_cache_duration')->default(60)->after('auto_translate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['default_language', 'available_languages', 'auto_translate', 'translation_cache_duration']);
        });
    }
}
