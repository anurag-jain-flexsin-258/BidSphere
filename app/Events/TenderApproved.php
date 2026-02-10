<?php

namespace App\Events;

use App\Models\Tender;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class TenderApproved
 *
 * Fired when an admin approves a tender.
 * Broadcasts new tender to global feed in real-time.
 */
class TenderApproved implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * The approved tender instance.
     *
     * @var Tender
     */
    public Tender $tender;

    /**
     * Create a new event instance.
     *
     * @param Tender $tender
     */
    public function __construct(Tender $tender)
    {
        // Load required relations for broadcasting
        $this->tender = $tender->load(['customer', 'images']);
    }

    /**
     * Broadcast channel.
     *
     * Public channel since feed is visible to everyone.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('global-feed');
    }

    /**
     * Broadcast event name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'tender.approved';
    }

    /**
     * Data sent to frontend.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id'            => $this->tender->id,
            'title'         => $this->tender->title,
            'description'   => $this->tender->description,
            'quantity'      => $this->tender->quantity,
            'approved_at'   => $this->tender->approved_at?->toDateTimeString(),
            'customer_name' => $this->tender->customer->name,
            'image'         => optional($this->tender->images->first())->image,
            'likes_count'   => $this->tender->likes_count,
            'views_count'   => $this->tender->views_count,
        ];
    }
}