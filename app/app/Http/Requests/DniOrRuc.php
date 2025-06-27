<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;

class DniOrRuc implements Rule
{
    /**
     * Determina si el valor cumple la regla.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Obtenemos el tipo de documento enviado
        $type = request()->input('document_type');

        if ($type === 'dni') {
            // DNI: exactamente 8 dígitos numéricos
            return preg_match('/^\d{8}$/', $value) === 1;
        }

        if ($type === 'ruc') {
            // RUC: 11 dígitos y comienza con 10 o 20
            return preg_match('/^(10|20)\d{9}$/', $value) === 1;
        }

        // Si no viene tipo válido, rechazamos
        return false;
    }

    /**
     * Mensaje de error que se mostrará en caso de fallo.
     *
     * @return string
     */
    public function message()
    {
        $type = request()->input('document_type');

        if ($type === 'dni') {
            return 'El DNI debe tener exactamente 8 dígitos numéricos.';
        }

        if ($type === 'ruc') {
            return 'El RUC debe tener 11 dígitos y comenzar con 10 o 20.';
        }

        return 'Tipo de documento inválido.';
    }
}
