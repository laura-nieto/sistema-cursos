<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Belamov\PostgresRange\Casts\TimestampRangeCast;
use App\Models\Student;

class Class_day extends Model
{
    use HasFactory;
    protected $casts = [
        'hour_range' => TimestampRangeCast::class,
    ];
    protected $fillable = [
        'course_id',
        'hour_range',
        'name_instructor',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class,'class_day_students','class_day_id','student_id')->withPivot('attendance');
    }
    public function getGetDateAttribute()
    {
        return implode("-",array_reverse(explode("-",explode(" ",explode('"',$this->hour_range)[1])[0])));
    }
    public function getGetISODateFormatAttribute()
    {
        return explode(" ",explode('"',$this->hour_range)[1])[0];
    }
    public function getGetStartDateAttribute()
    {
        return explode(' ',explode('"',$this->hour_range)[1])[1];
    }
    public function getGetEndDateAttribute()
    {
        return explode(' ',explode('"',$this->hour_range)[3])[1];
    }
}