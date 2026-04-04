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
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->integer('driver_limit')->default(10)->after('user_limit');
            $table->integer('monthly_reports')->default(50)->after('driver_limit');
            $table->integer('monthly_alerts')->default(100)->after('monthly_reports');
            $table->boolean('is_trial')->default(false)->after('is_active');
            $table->integer('trial_days')->default(0)->after('is_trial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['driver_limit', 'monthly_reports', 'monthly_alerts', 'is_trial', 'trial_days']);
        });
    }
};
