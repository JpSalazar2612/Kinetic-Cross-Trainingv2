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
        // Definimos los tipos de membresía que existiran.
        $tipos = ['Básico', 'Premium', 'VIP', 'Empresarial'];

        return [
            // El nombre debe ser único.
            'nombre' => $this->faker->unique()->randomElement($tipos) . ' ' . $this->faker->numberBetween(1, 5),
            
            'descripcion' => $this->faker->sentence(8),
            
            // Precios entre 19.99 y 99.99
            'precio' => $this->faker->randomFloat(2, 19.99, 99.99),
            
            // Duración en días (entre 30 días y 365 días)
            'duracion_dias' => $this->faker->randomElement([30, 90, 180, 365]),
        ];
    }
}