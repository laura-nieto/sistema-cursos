<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy_course_type extends Model
{
    use HasFactory;
    protected $fillable = [
        'academy_id',
        'course_type_id',
    ];
}
