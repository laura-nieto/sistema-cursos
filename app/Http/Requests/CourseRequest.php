<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sucursalAsociada' => ['required'],
            'tipoCurso' => ['required'],
            'horasTotales' => ['required','numeric','between:5,23'],
            'minutosTotales' => ['required','numeric','between:0,59'],
            'capacidadDeEstudiantes' => ['required','numeric','min:1'],
        ];
    }
}
