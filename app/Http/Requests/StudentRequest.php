<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class studentRequest extends FormRequest
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
        // dd($request->all());
        return [
            'nombreAlumno' => ['required','max:100'],
            'apellidoAlumno' => ['required','max:100'],
            'dni' => 
                ['required',
                'numeric',
                'min:0',
                Rule::unique('students')->ignore($request->id)],
            'fechaDeNacimiento'=> ['required','before_or_equal:'.date('Y-m-d',mktime(0, 0, 0,date("m"),date("d"),date("Y")-14))],
            'prefijo' => ['nullable','size:2'],
            'telefono' => ['nullable','size:8'],
            'email' => 
                ['nullable',
                'email:rfc',
                Rule::unique('students')->ignore($request->id)],

        ];
    }
}
