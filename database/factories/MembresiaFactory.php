<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membresia; // Importar el modelo

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membresia>
 */
class MembresiaFactory extends Factory
{
    /**
     * Define el modelo correspondiente para la Factory.
     *
     * @var string
     */
    protected $model = Membresia::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Usamos palabras aleatorias y un número único para GARANTIZAR la unicidad
        // y evitar cualquier conflicto con los nombres fijos creados en el Seeder (Básico, Plata, etc.)
        $name = $this->faker->unique()->randomElement(['Elite', 'Pro', 'Ultimate', 'Gold', 'Master', 'Focus']);

        return [
            // Utilizamos faker->unique() y un número aleatorio grande para asegurar un nombre único.
            'nombre' => $name . ' Aleatorio ' . $this->faker->unique()->randomNumber(4), // Ejemplo: "Elite Aleatorio 4529"
            
            'descripcion' => $this->faker->sentence(10),
            
            'precio' => $this->faker->randomFloat(2, 500.00, 5000.00),
            
            'duracion_dias' => $this->faker->randomElement([30, 90, 180, 365]),
        ];
    }
}