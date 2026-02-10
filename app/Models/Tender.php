<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Tender
 *
 * Represents a customer-created tender.
 * Acts as the core entity for feed system.
 *
 * @property int $id
 * @property int $customer_id
 * @property string $title
 * @property string $description
 * @property int $quantity
 * @property string $status
 * @property int $views_count
 * @property int $likes_count
 * @property \Carbon\Carbon|null $approved_at
 * @property \Carbon\Carbon|null $expires_at
 *
 * @package App\Models
 */
class Tender extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'quantity',
        'status',
        'approved_at',
        'approved_by',
        'is_featured',
        'expires_at',
        'views_count',
        'likes_count',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at'  => 'datetime',
        'is_featured' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Tender owner.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Admin who approved the tender.
     *
     * @return BelongsTo
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Tender images.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(TenderImage::class);
    }

    /**
     * Tender attachments.
     *
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TenderAttachment::class);
    }

    /**
     * Tender categories.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'tender_category');
    }

    /**
     * Tender likes.
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(TenderLike::class);
    }

    /**
     * Tender views.
     *
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(TenderView::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope only approved tenders.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved')
                     ->whereNotNull('approved_at');
    }

    /**
     * Scope active (not expired) tenders.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope for global feed ordering.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFeedOrder(Builder $query): Builder
    {
        return $query->orderByDesc('approved_at')
                     ->orderByDesc('created_at');
    }
}