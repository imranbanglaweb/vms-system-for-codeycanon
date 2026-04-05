<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('recommended_for')->nullable()->after('last_updated_at');
            $table->integer('display_order')->default(0)->after('recommended_for');
        });
    }

    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['recommended_for', 'display_order']);
        });
    }
};