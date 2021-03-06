<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
            'name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'gender' => 'required',
            'dni' => 
                ['required',
                'numeric',
                'min:0',
                Rule::unique('users')->ignore($request->id)],
            'email' => 
                ['nullable',
                'email:rfc',
                Rule::unique('users')->ignore($request->id)],
            'role' => 'required',
            'password' => 'required|min:6',
            'academy_id' => Rule::requiredIf( $this->role != 1 && $this->role != 2 )
        ];
    }
}
