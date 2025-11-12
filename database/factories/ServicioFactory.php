<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Servicio; // Asegúrate de importar el modelo

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servicio>
 */
class ServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->words(3, true),
            // ELIMINAMOS esta línea: 'membresia_id' => \App\Models\Membresia::factory(), 
            // Ya que la asignaremos en el Seeder (each()) con IDs existentes.
            'tipo' => $this->faker->randomElement(['Clase Grupal', 'Entrenamiento Personal', 'Nutrición', 'Masaje']),
            'detalles' => $this->faker->paragraph(2),
        ];
    }
}