<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateTenderViewsTable
 *
 * Stores individual view logs for analytics and tracking.
 * Allows anonymous views (customer_id nullable).
 *
 * @package Database\Migrations
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Throwable
     */
    public function up(): void
    {
        Schema::create('tender_views', function (Blueprint $table) {

            $table->id();

            // Relationships
            $table->foreignId('tender_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Optional analytics fields
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // Performance index
            $table->index('tender_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws \Throwable
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_views');
    }
};