<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            // Tipo y número de documento
            'document_type'   => 'required|in:dni,ruc',
            'document_number' => ['required', new DniOrRuc()],

            // Campos para DNI
            'f_name'   => 'required_if:document_type,dni|string|max:255',
            'm_name'   => 'nullable|string|max:255',
            'l_name'   => 'required_if:document_type,dni|string|max:255',
            'gender'   => 'required_if:document_type,dni|in:Male,Female',

            // Campo para RUC
            'razon_social' => 'required_if:document_type,ruc|string|max:255',

            // Campos comunes
            'address'   => 'required|string',
            'country'   => 'required',
            'state'     => 'required',
            'city_id'   => 'required|integer',
            'email'     => 'nullable|email',
            'mobile'    => 'required|digits:9',
            'reference_name'   => 'nullable|string',
            'reference_mobile' => 'nullable|digits:9',

            // Aquí tus reglas para el repeater, si aplica...
        ];
    }

    public function messages()
    {
        return [
            // Documento
            'document_type.required'     => 'Seleccione un tipo de documento.',
            'document_type.in'           => 'Tipo de documento inválido.',
            'document_number.required'   => 'Por favor, ingrese el documento.',
            // (tu regla DniOrRuc ya retorna el mensaje adecuado)

            // DNI
            'f_name.required_if'         => 'Por favor, ingrese el primer nombre.',
            'l_name.required_if'         => 'Por favor, ingrese el apellido.',
            'gender.required_if'         => 'El género es obligatorio.',

            // RUC
            'razon_social.required_if'   => 'Por favor, ingrese la razón social.',

            // Campos comunes
            'address.required'           => 'Por favor, ingrese la dirección.',
            'country.required'           => 'Por favor, seleccione el país.',
            'state.required'             => 'Por favor, seleccione el estado.',
            'city_id.required'           => 'Por favor, seleccione la ciudad.',
            'city_id.integer'            => 'Ciudad inválida.',
            'mobile.required'            => 'Por favor, ingrese el número de celular.',
            'mobile.digits'              => 'El número debe tener 9 dígitos.',
            'email.email'                => 'Por favor, ingrese un correo válido.',
            'reference_mobile.digits'    => 'El número de referencia debe tener 9 dígitos.',
        ];
    }
}
