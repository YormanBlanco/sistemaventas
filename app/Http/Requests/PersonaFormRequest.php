<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaFormRequest extends FormRequest
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
            'nombre'=>'required|max:250',
            'tipo_documento'=>'required|max:45',
            'num_documento'=>'required|max:20',
            'direccion'=>'max:450',
            'telefono'=>'max:15',
            'email'=>'max:50',
        ];
    }
}
