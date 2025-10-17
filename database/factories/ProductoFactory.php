<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nombre' => $this->faker->randomElement(['Bebida Energética', 'Barra de Proteína', 'Camiseta', 'Toalla Deportiva']) . ' - ' . $this->faker->colorName(),
            'descripcion' => $this->faker->sentence(6),
            // Precio entre 2.50 y 50.00
            'precio' => $this->faker->randomFloat(2, 2.50, 50.00),
            // Stock disponible
            'stock' => $this->faker->numberBetween(10, 200),
        ];
    }
}
