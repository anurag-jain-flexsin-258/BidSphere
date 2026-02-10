<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Services\FeedService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Class FeedController
 *
 * Handles global tender feed for customers.
 * Thin controller — business logic delegated to FeedService.
 *
 * @package App\Http\Controllers\Feed
 */
class FeedController extends Controller
{
    /**
     * @var FeedService
     */
    protected FeedService $feedService;

    /**
     * FeedController constructor.
     *
     * @param FeedService $feedService
     */
    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * Display global tender feed.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tenders = $this->feedService->getGlobalFeed(10);

        return view('feed.index', compact('tenders'));
    }

    /**
     * Show a single tender in feed.
     * Also records a view.
     *
     * @param Request $request
     * @param Tender $tender
     * @return View
     */
    public function show(Request $request, Tender $tender): View
    {
        abort_unless($tender->status === 'approved', 404);

        $this->feedService->recordView(
            tender: $tender,
            customerId: auth()->id(),
            ip: $request->ip(),
            userAgent: $request->userAgent()
        );

        $hasLiked = $this->feedService->hasLiked($tender, auth()->id());

        return view('feed.show', compact('tender', 'hasLiked'));
    }

    /**
     * Toggle like for a tender.
     *
     * @param Tender $tender
     * @return JsonResponse
     */
    public function toggleLike(Tender $tender): JsonResponse
    {
        abort_unless(auth()->check(), 403);

        $liked = $this->feedService->toggleLike(
            tender: $tender,
            customerId: auth()->id()
        );

        return response()->json([
            'success'      => true,
            'liked'        => $liked,
            'likes_count'  => $tender->fresh()->likes_count,
        ]);
    }
}