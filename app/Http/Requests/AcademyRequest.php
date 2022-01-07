<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class AcademyRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'nombreDeAcademia' => 'required|max:100',
            'calle' => 'required|max:20',
            'alturaDeLaCalle'=>'required|numeric|min:0',
            'responsable' => 'required|max:100',
            'prefijo' => 'nullable|size:2',
            'telefono' => 'required|size:8',
            'email' => 
                ['required',
                'email:rfc',
                Rule::unique('academies')->ignore($request->id)],
            'noc' => 'required|max:255',
            'tiposDeCurso'=> 'required',
        ];
    }
}
