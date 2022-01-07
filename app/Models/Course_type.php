<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_type extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_type_name',
        'description',
    ];
    public function courses()
    {
        return $this->hasMany(Course::class,'type_course_id');
    }
    public function academies()
    {
        return $this->belongsToMany(Academy::class,'academy_course_types','course_type_id','academy_id');
    }
}
