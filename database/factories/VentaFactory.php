<?php

namespace Database\Factories;

use App\Models\Venta;
use App\Models\User;
use App\Models\Membresia;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 1. user_id (REQUIRED): Asegura que siempre se cree un usuario si no se especifica uno.
            'user_id' => User::factory(), 

            // 2. membresia_id (OPTIONAL): Crea una membresía o lo deja nulo (depende del test)
            'membresia_id' => Membresia::factory(), 

            'total' => $this->faker->randomFloat(2, 100, 1500),
            'fecha_venta' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'metodo_pago' => $this->faker->randomElement(['Tarjeta', 'Efectivo', 'Transferencia', 'PayPal']),
        ];
    }
    
    /**
     * Define the state where membresia_id is null.
     */
    public function noMembresia()
    {
        return $this->state([
            'membresia_id' => null,
        ]);
    }
}
