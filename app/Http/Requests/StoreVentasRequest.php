<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Corregido: Validar los campos reales de la tabla 'ventas'
            // user_id es llenado por el sistema, no requerido aquí
            'membresia_id' => 'nullable|exists:membresias,id', // Puede ser nulo
            'total' => 'required|numeric|min:0',
            'fecha_venta' => 'required|date',
            'metodo_pago' => 'required|string|max:50',
        ];
    }
}
