<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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

           'f_name' => 'required',
            'l_name' => 'required',
            'm_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city_id' => 'required',
            //'email' => 'required',
            'mobile' => 'required',
            //'alternate_no' => 'required',
            'gender' => 'required',

        ];
    }

    public function messages()
    {
        return [

            'f_name.required' => 'Por favor, ingrese el nombre.',
            'l_name.required' => 'Por favor, ingrese el segundo nombre.',
            'm_name.required' => 'Por favor, ingrese el apellido.',
            'address.required' => 'Por favor, ingrese la dirección.',
            'country.required' => 'Por favor, seleccione el país.',
            'state.required' => 'Por favor, seleccione el estado.',
            'city_id.required' => 'Por favor, seleccione la ciudad.',
            // 'email' => 'required',
            'mobile.required' => 'Por favor, ingrese el número de celular.',
            // 'alternate_no' => 'required',
            // 'gender.required' => 'El género es obligatorio',


        ];
    }
}
