<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TenderLike
 *
 * Stores like interactions for tenders.
 *
 * @property int $id
 * @property int $tender_id
 * @property int $customer_id
 *
 * @package App\Models
 */
class TenderLike extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'tender_id',
        'customer_id',
    ];

    /**
     * Related tender.
     *
     * @return BelongsTo
     */
    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * Customer who liked.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}