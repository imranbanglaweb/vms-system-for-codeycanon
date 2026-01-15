<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Employee or driver receiving the notification
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('system'); // system, email, sms, etc.
            $table->string('channel')->nullable(); // e.g., "email", "database", "both"
            $table->string('reference_table')->nullable(); // e.g., "travel_requests"
            $table->unsignedBigInteger('reference_id')->nullable(); // e.g., related request id
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_sent')->default(false); // For email sent tracking

            // Common fields
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Note: foreign key constraint to `employees` is added in a later migration
            // to ensure the `employees` table exists before creating the FK. See
            // 2025_11_01_000002_add_user_fk_to_transport_notifications_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport_notifications');
    }
}
