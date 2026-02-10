<?php

namespace App\Services;

use App\Models\Tender;
use App\Models\TenderLike;
use App\Models\TenderView;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class FeedService
 *
 * Handles all feed-related business logic.
 * Keeps controllers clean and thin.
 *
 * @package App\Services
 */
class FeedService
{
    /**
     * Get global approved tender feed.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getGlobalFeed(int $perPage = 10): LengthAwarePaginator
    {
        return Tender::query()
            ->approved()
            ->active()
            ->with(['customer', 'images'])
            ->feedOrder()
            ->paginate($perPage);
    }

    /**
     * Record a tender view.
     *
     * - Prevent duplicate view from same customer within session
     * - Increment cached counter
     *
     * @param Tender $tender
     * @param int|null $customerId
     * @param string|null $ip
     * @param string|null $userAgent
     * @return void
     */
    public function recordView(
        Tender $tender,
        ?int $customerId,
        ?string $ip,
        ?string $userAgent
    ): void {
        // Prevent duplicate views by same logged-in user
        if ($customerId) {
            $alreadyViewed = TenderView::where('tender_id', $tender->id)
                ->where('customer_id', $customerId)
                ->exists();

            if ($alreadyViewed) {
                return;
            }
        }

        DB::transaction(function () use ($tender, $customerId, $ip, $userAgent) {
            TenderView::create([
                'tender_id'  => $tender->id,
                'customer_id'=> $customerId,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);

            $tender->increment('views_count');
        });
    }

    /**
     * Toggle like for a tender.
     *
     * - If already liked → remove like
     * - If not liked → add like
     *
     * @param Tender $tender
     * @param int $customerId
     * @return bool True if liked, false if unliked
     */
    public function toggleLike(Tender $tender, int $customerId): bool
    {
        return DB::transaction(function () use ($tender, $customerId) {

            $existing = TenderLike::where('tender_id', $tender->id)
                ->where('customer_id', $customerId)
                ->first();

            if ($existing) {
                $existing->delete();
                $tender->decrement('likes_count');
                return false;
            }

            TenderLike::create([
                'tender_id'  => $tender->id,
                'customer_id'=> $customerId,
            ]);

            $tender->increment('likes_count');

            return true;
        });
    }

    /**
     * Check if customer already liked a tender.
     *
     * @param Tender $tender
     * @param int|null $customerId
     * @return bool
     */
    public function hasLiked(Tender $tender, ?int $customerId): bool
    {
        if (!$customerId) {
            return false;
        }

        return TenderLike::where('tender_id', $tender->id)
            ->where('customer_id', $customerId)
            ->exists();
    }
}