<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'street',
        'streetHeight',
        'responsible',
        'phone',
        'email',
        'noc',
        'isActive',
    ];
    protected $attributes = [
        'isActive' => true,
    ];
    public function branchOffices()
    {
        return $this->hasMany(Branch_office::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function coursesType()
    {
        return $this->belongsToMany(Course_type::class,'academy_course_types','academy_id','course_type_id');   
    }
    public function scopeName($query,$name)
    {
        if ($name) {
            return $query->where('academies.name','ILIKE', "%$name%");
        }
    }
    public function scopeEmail($query,$email)
    {
        if ($email) {
            return $query->where('academies.email','ILIKE', "%$email%");
        }
    }
    public function scopeIsDisabled($query,$state)
    {
        if ($state) {
            return $query;
        }
        return $query->where('academies.isActive',true);
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
}
