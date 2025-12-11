<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;

    /**
     * Guard name for authentication.
     */
    protected $guard = 'customer';

    /**
     * Mass-assignable fields.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'dob',
        'address',
        'gst_no',
        'image',
        'password',
        'otp',
        'otp_verified',
        'profile_completed',
    ];

    /**
     * Hidden fields for arrays / JSON.
     */
    protected $hidden = [
        'otp',
        'password',
    ];
}
