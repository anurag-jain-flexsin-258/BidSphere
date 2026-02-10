<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TenderView
 *
 * Stores view logs for analytics.
 *
 * @property int $id
 * @property int $tender_id
 * @property int|null $customer_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 *
 * @package App\Models
 */
class TenderView extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'tender_id',
        'customer_id',
        'ip_address',
        'user_agent',
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
     * Viewing customer (nullable).
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}