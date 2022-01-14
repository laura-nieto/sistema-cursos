<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeDni($query,$dni)
    {
        if ($dni) {
            $query->with('student')->whereHas('student',function($query)use($dni){
                return $query->where('students.dni','ILIKE', "$dni%");
            });
        }
    }
    public function scopeLastname($query,$lastname)
    {
        if ($lastname) {
            $query->with('student')->whereHas('student',function($query)use($lastname){
                $query->where('students.last_name','ILIKE', "%$lastname%");
            });
        }
    }
}
