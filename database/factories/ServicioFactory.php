<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            // El 'membresia_id' se asignará en el Seeder para asegurar una ID válida
             'membresia_id' => \App\Models\Membresia::factory(), // Alternativa si no usaras make()->each()
            'tipo' => $this->faker->randomElement(['Clase Grupal', 'Entrenamiento Personal', 'Nutrición', 'Masaje']),
            'detalles' => $this->faker->paragraph(2),
        ];
    }
}
