<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderAttachment extends Model
{
    protected $fillable = [
        'tender_id',
        'uploaded_by',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Attachment belongs to a tender
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    // Uploader (admin or system user)
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
