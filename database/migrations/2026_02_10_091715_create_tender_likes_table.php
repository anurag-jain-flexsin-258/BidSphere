<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateTenderLikesTable
 *
 * Stores individual likes per tender per customer.
 * Prevents duplicate likes via unique constraint.
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
        Schema::create('tender_likes', function (Blueprint $table) {

            $table->id();

            // Relationships
            $table->foreignId('tender_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            // Prevent duplicate likes
            $table->unique(['tender_id', 'customer_id']);

            // Performance index
            $table->index('tender_id');
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
        Schema::dropIfExists('tender_likes');
    }
};