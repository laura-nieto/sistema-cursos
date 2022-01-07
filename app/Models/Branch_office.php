<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch_office extends Model
{
    use HasFactory;
    protected $fillable = [
        'academy_id',
        'branch_name',
        'street',
        'streetHeight',
        'isActive',
        'noc',
    ];
    protected $attributes = [
        'isActive' => true,
    ];
    public function academy(){
        return $this->belongsTo(Academy::class);
    }
    public function courses(){
        return $this->hasMany(Course::class);
    }
    public function scopeNameBranchOffice($query,$name)
    {
        if ($name) {
            return $query->where('branch_offices.branch_name','ILIKE', "%$name%");
        }
    }
    public function scopeNameAcademy($query,$nameAcademy)
    {
        return $query
                ->select('branch_offices.*')
                ->leftJoin('academies','branch_offices.academy_id','=','academies.id')
                ->where('name','ILIKE',"%$nameAcademy%");
    }
    public function scopeIsDisabled($query,$state)
    {
        if ($state) {
            return $query;
        }
        return $query->where('branch_offices.isActive',true);
    }
    public function scopeForAcademyId($query,$academyId)
    {
        if($academyId)
        {
            return $query->where('branch_offices.academy_id','=',$academyId);
        }

    }
}
