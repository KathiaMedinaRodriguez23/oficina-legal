<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointment extends FormRequest
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
              //'exists_client' => 'required',
              //'new_client' => 'required',
              'email' => 'required|email',
              'date' => 'required',
              'time' => 'required',
        ];
    }
      public function messages()
    {
        return [
              'email.required' => 'Ingrese un correo electronico.',
              'date.required' => 'Porfavor ingrese una fecha.',
              'time.required' => 'Porfavor ingrese una hora.',


        ];
    }
}
