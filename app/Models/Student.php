<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Class_day;

class Student extends Model
{
    use HasFactory;
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'last_name',
        'gender',
        'dni',
        'birth_date',
        'phone',
        'email',
        'isActive'
    ];
    protected $attributes = [
        'isActive' => true,
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class,'course_students','student_id','course_id');
    }
    public function classDays()
    {
        return $this->belongsToMany(Class_day::class,'class_day_students','student_id','class_day_id')->withPivot('attendance');
    }
    public function scopeIsDisabled($query,$state)
    {
        if ($state) {
            return $query;
        }
        return $query->where('students.isActive',true);
    }
    public function scopeEmail($query,$email)
    {
        if ($email) {
            return $query->where('students.email','ILIKE', "%$email%");
        }
    }
    public function scopeDni($query,$dni)
    {
        if ($dni) {
            return $query->where('students.dni','ILIKE', "$dni%");
        }
    }
    public function getGetPrefijoAttribute()
    {
        if(strlen($this->phone) === 8)
        {
            return null;
        };
        return substr($this->phone,0,-8);
    }
    public function getGetPhoneAttribute()
    {
        return substr($this->phone,-8,strlen($this->phone));
    }
    public function getGetISOFormatBirthDateAttribute()
    {
        return implode("-",array_reverse(explode('-',$this->birth_date)));
    }
}
