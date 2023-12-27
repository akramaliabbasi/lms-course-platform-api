<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    use HasFactory;

    protected $table = 'course_user';


    protected $fillable = [
        'user_id',
        'course_id',
    ];

    // Optionally, you can define relationships to the User and Course models
    // This assumes you have User and Course models in the 'App\Models' namespace

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
