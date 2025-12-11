<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'gender', 'dob', 'address', 'gst_no', 'image', 'password', 'otp', 'email_verified_at'
    ];

    protected $hidden = ['password', 'otp'];
}
