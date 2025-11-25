<?php

namespace Database\Factories;

use App\Models\Servicio;
use App\Models\Membresia; // Importar el modelo Membresia

use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente.
     *
     * @var string
     */
    protected $model = Servicio::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        // CORRECCIÓN CLAVE: Asegurar que siempre se cree o se encuentre un ID de Membresia válido.
        // Si no existe ninguna Membresia, crea una automáticamente.
        $membresiaId = Membresia::factory()->create()->id; 
        // Si quieres evitar la creación en cada llamada si ya existe una Membresia:
        // $membresiaId = Membresia::inRandomOrder()->first()->id ?? Membresia::factory()->create()->id;
        
        // Uso el primero (crear si no existe) ya que en los tests usamos RefreshDatabase.

        return [
            // El factory ahora asegura que esta relación se cumple.
            'membresia_id' => $membresiaId, 
            'nombre' => $this->faker->unique()->word(),
            'precio' => $this->faker->randomFloat(2, 5.00, 500.00),
            'duracion_minutos' => $this->faker->numberBetween(30, 180),
            'tipo' => $this->faker->randomElement(['Clase Grupal', 'Entrenamiento Personal', 'Nutrición', 'Masaje']),
            'detalles' => $this->faker->sentence(),
            
        ];
    }
}