<?php

namespace Database\Factories;

use App\Models\Membresia;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembresiaFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente.
     *
     * @var string
     */
    protected $model = Membresia::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            // SOLUCIÓN: Usamos 'sentence' dentro de unique() para generar una frase única.
            // Esto crea una gran cantidad de posibles nombres, evitando el OverflowException.
            'nombre' => $this->faker->unique()->sentence(3, true), 
            
            // 'tipo' NO debe ser unique si es un conjunto pequeño de valores.
            'tipo' => $this->faker->randomElement(['Mensual', 'Trimestral', 'Anual', 'Día Libre']),

            'costo' => $this->faker->randomFloat(2, 20.00, 200.00),
            'detalles' => $this->faker->paragraph(),
            'duracion_dias' => $this->faker->numberBetween(30, 365),
        ];
    }
}