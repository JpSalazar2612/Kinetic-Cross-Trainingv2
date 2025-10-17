<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Venta; // Importamos el modelo

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
{
    /**
     * Define el modelo correspondiente para la Factory.
     *
     * @var string
     */
    protected $model = Venta::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // NOTA: Solo incluimos los campos 'total' y 'metodo_pago'.
            // Los campos 'user_id' y 'membresia_id' se asignan en el DatabaseSeeder.

            // Monto total de la venta (ej. 50.00 a 500.00)
            'total' => $this->faker->randomFloat(2, 50.00, 500.00),
            
            // Método de pago
            'metodo_pago' => $this->faker->randomElement(['Tarjeta', 'Efectivo', 'Transferencia']),
        ];
    }
}
