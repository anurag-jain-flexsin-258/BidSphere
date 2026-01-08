<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderImage extends Model
{
    protected $fillable = [
        'tender_id',
        'image',
        'sort_order',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Image belongs to a tender
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
