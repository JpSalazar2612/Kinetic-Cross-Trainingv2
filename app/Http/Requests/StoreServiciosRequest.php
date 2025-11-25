<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiciosRequest extends FormRequest
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
        return [
            // membresia_id debe existir en la tabla membresias
            'membresia_id' => 'required|integer|exists:membresias,id',
            // Debe ser único, string y requerido para la creación
            'nombre' => 'required|string|max:255|unique:servicios,nombre',
            'precio' => 'required|numeric|min:0.01',
            'duracion_minutos' => 'required|integer|min:10|max:1440',
            'tipo' => 'required|string|max:50', // Tipo de servicio
            'detalles' => 'nullable|string', // Detalles opcionales
        ];
    }
}