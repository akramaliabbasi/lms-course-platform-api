<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'username',
        'email_verified_at',
		'password',
        'remember_token',
        'media_token',
        'created_at',
        'updated_at',
    ];

    // Add any additional methods or relationships here
}
