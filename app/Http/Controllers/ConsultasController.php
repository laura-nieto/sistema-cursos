<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Course_type;
use Illuminate\Http\Request;

class ConsultasController extends Controller
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
        $response = collect();
        foreach ($sucursales as $sucursal) {
            if ($sucursal->courses->where('isActive',true)->contains('type_course_id',$tipoID)) {
                foreach ($sucursal->courses as $course) {
                    if ($course->isActive === true && $course->firstDay()->get() && !$response->contains('id',$sucursal->id)) {
                        $response->push($sucursal); //SUCURSALES QUE TIENE EL TIPO DE CURSO
                    }
                }
            }
        }
        return response()->json($response);
    }
}
