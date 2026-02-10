<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class ModifyTendersTableAddFeedColumns
 *
 * Adds feed-related aggregate columns to tenders table.
 * These columns are optimized for fast listing queries.
 *
 * - views_count  : Cached total views
 * - likes_count  : Cached total likes
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
        Schema::table('tenders', function (Blueprint $table) {

            // Cached counters for performance optimization
            $table->unsignedBigInteger('views_count')
                ->default(0)
                ->after('is_featured')
                ->comment('Cached total number of views');

            $table->unsignedBigInteger('likes_count')
                ->default(0)
                ->after('views_count')
                ->comment('Cached total number of likes');

            // Index for faster feed sorting
            $table->index(['status', 'approved_at']);
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
        Schema::table('tenders', function (Blueprint $table) {

            $table->dropIndex(['status', 'approved_at']);
            $table->dropColumn(['views_count', 'likes_count']);
        });
    }
};