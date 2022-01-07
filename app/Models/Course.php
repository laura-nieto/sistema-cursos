<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_hours',
        'student_capacity',
        'modality',
        'expiration',
        'isActive',
        'branch_office_id',
        'type_course_id',
    ];
    protected $attributes = [
        'isActive' => true,
    ];
    public function branchOffice()
    {
        return $this->belongsTo(Branch_office::class);
    }
    public function courseType()
    {
        return $this->belongsTo(Course_type::class,'type_course_id');
    }
    public function certificates(){
        return $this-> hasMany(Certificate::class,'course_id');
    }
    public function classDays()
    {
        return $this->HasMany(Class_day::class,'course_id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class,'course_students','course_id','student_id');
    }
    public function scopeNameAssociatedBranchOffice($query,$nameBranchOffice)
    {
        return $query
                ->select('courses.*')
                ->leftJoin('branch_offices','courses.branch_office_id','=','branch_offices.id')
                ->where('branch_name','ILIKE',"%$nameBranchOffice%");
    }
    public function scopeNameAssociatedCourseType($query,$nameCourseType)
    {
        return $query
                ->select('courses.*')
                ->leftJoin('course_types','courses.type_course_id','=','course_types.id')
                ->where('course_type_name','ILIKE',"%$nameCourseType%");
    }
    public function scopeIsDisabled($query,$state)
    {
        if ($state) {
            return $query;
        }
        return $query->where('courses.isActive',true);
    }
    public function scopeCoursesForUser($query,$userAuth)
    {
        if($userAuth->academy_id === null)
        {
            return $query;
        }
        return $query->where('academy_id',"$userAuth->academy_id");
    }
} 