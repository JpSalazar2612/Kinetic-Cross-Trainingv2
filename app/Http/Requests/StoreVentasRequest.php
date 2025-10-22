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
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:ventas,producto_id',
            'servicio_id' => 'required|exists:ventas,servicio_id',
            'cantidad' => 'required|exists:ventas,cantidad',
            'total' => 'required|exists:ventas,total',
        ];
    }
}
