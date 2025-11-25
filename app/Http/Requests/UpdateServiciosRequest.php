<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;  // Importar la interfaz Validator
use Illuminate\Http\Exceptions\HttpResponseException;  // Importar la excepción HttpResponseException
class UpdateServiciosRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        // El ID del servicio se obtiene de la ruta (asumiendo Route Model Binding)
        // Nota: Asegúrate de que en el controlador la variable de ruta se llama 'servicio'.
        $servicioId = $this->route('servicio')->id;

        return [
            // Si se envía, debe ser un ID de membresía válido.
            'membresia_id' => 'sometimes|integer|exists:membresias,id',

            // Si se envía, debe ser único, ignorando el servicio actual.
            'nombre' => [
                'sometimes', // Solo valida si el campo está presente
                'string',
                'max:255',
                Rule::unique('servicios', 'nombre')->ignore($servicioId),
            ],

            // Si se envían, se validan. Si no, se ignoran (por 'sometimes').
            'precio' => 'sometimes|numeric|min:0.01',
            'duracion_minutos' => 'sometimes|integer|min:10|max:1440',
            'tipo' => 'sometimes|string|max:50',
            'detalles' => 'sometimes|string|nullable',
        ];
    }
     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error de validación en la actualización',
            'errors' => $validator->errors()
        ], 422));
    }
}