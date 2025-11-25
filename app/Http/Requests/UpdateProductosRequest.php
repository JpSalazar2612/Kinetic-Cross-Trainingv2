<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importar la clase Rule para la regla unique

class UpdateProductosRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // 1. OBTENER EL ID DEL PRODUCTO
        // Usamos el Route Model Binding para obtener el ID del producto que estamos actualizando.
        // Esto es necesario para que la regla 'unique' ignore el nombre del producto actual.
        $productoId = $this->route('producto')->id;

        return [
            // El 'nombre' es opcional (sometimes), pero si está presente, debe ser único
            // e ignorar el ID del producto que se está actualizando.
            'nombre' => [
                'sometimes', 
                'required', // Si se envía, es requerido
                'string', 
                'max:255',
                Rule::unique('productos', 'nombre')->ignore($productoId),
            ],
            
            // El 'precio' es opcional, pero si se envía, debe ser numérico y no negativo.
            'precio' => 'sometimes|required|numeric|min:0',
            
            // El 'stock' es opcional, pero si se envía, debe ser un entero y no negativo.
            'stock' => 'sometimes|required|integer|min:0',
            
            // La 'descripcion' es opcional (nullable significa que puede ser null en la DB).
            'descripcion' => 'sometimes|string|nullable',
        ];
    }
}