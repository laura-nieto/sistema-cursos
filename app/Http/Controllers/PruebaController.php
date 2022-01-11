<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Course;
use App\Models\Course_type;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function obtenerAcademias($tipoID)
    {
        if (auth()->user()->academy_id === null) {
            $coincidencias = Course_type::findOrFail($tipoID)->academies->where('isActive',true);
        }else{
            $coincidencias = Course_type::findOrFail($tipoID)->academies->where('id',auth()->user()->academy_id);
        }
        return response()->json($coincidencias);
    }
    public function obtenerSucursales($tipoID,$academiaID)
    {
        $sucursales = Academy::findOrFail($academiaID)->branchOffices;
        foreach ($sucursales as $sucursal) {
            if ($sucursal->courses->where('isActive',true)->contains('type_course_id',$tipoID)) {
                $response[] = $sucursal; //SUCURSALES QUE TIENE EL TIPO DE CURSO
            }
        }
        return response()->json($response);
    }
    public function obtenerCursos($tipoID,$academiaID,$sucursalID)
    {
        $cursos = Course::where('branch_office_id',$sucursalID)->where('type_course_id',$tipoID)->where('isActive',true)->get();
        return response()->json($cursos);
    }
}
