<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            // Company
            $table->foreignId('company_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // User (nullable if needed)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Plan → now correctly references subscription_plans table
            $table->foreignId('plan_id')
                  ->constrained('subscription_plans') // ✅ FIXED
                  ->cascadeOnDelete();

            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();

            $table->enum('status', ['active','expired','suspended','pending'])
                  ->default('pending');

            $table->string('payment_method')->nullable(); // manual / stripe
            $table->string('transaction_ref')->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
}
