<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use SoftDeletes, HasFactory;

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
    ];

    /**
     * Casts
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Tender belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Tender was approved by a user (admin)
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Tender has many images
    public function images()
    {
        return $this->hasMany(TenderImage::class);
    }

    // Tender has many attachments
    public function attachments()
    {
        return $this->hasMany(TenderAttachment::class);
    }

    // Tender belongs to many categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tender_category');
    }
}
