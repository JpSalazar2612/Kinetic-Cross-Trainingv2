<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Asegúrate de tener esta importación
use Illuminate\Support\Str; 

use App\Models\User;
use App\Models\Servicio;
use App\Models\Producto;
use App\Models\Venta; // ¡CRUCIAL! Esta es la línea que resuelve el error.
use App\Models\Membresia;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear el usuario administrador
        $admin = User::factory()->create([
            'name' => 'Brandon Soto',
            'email' => 'BrandonSoto@example.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Crear 10 usuarios regulares
        User::factory(10)->create();
        
        // 3. Crear las 4 Membresías base
        Membresia::factory(4)->create();
        $membresias = Membresia::all();
        
        // 4. Crear Servicios: Cada Servicio debe pertenecer a una Membresía.
        Servicio::factory(10)->make()->each(function ($servicio) use ($membresias) {
            $servicio->membresia_id = $membresias->random()->id;
            $servicio->save();
        });

        // 5. Crear 8 Productos
        Producto::factory(8)->create();
        $productos = Producto::all();

        // 6. Crear 45 Ventas
        $users = User::all();
        Venta::factory(45)->make()->each(function ($venta) use ($users, $membresias) {
            $venta->user_id = $users->random()->id;
            $venta->membresia_id = $membresias->random()->id; 
            $venta->save();
        });
        $ventas = Venta::all();


        // -- ESTABLECER RELACIONES MUCHOS A MUCHOS --

        // 7. Asignar 1 a 4 Membresías aleatorias a CADA Usuario.
        foreach ($users as $user) {
            // Utilizamos datos pivote para simular la fecha de inicio/fin de la membresía
            $pivoteData = $membresias->random(rand(1, 4))->mapWithKeys(function ($membresia) {
                $fechaInicio = now()->subDays(rand(1, 365));
                $fechaFin = $fechaInicio->copy()->addDays($membresia->duracion_dias);

                return [
                    $membresia->id => [
                        'fecha_inicio' => $fechaInicio,
                        'fecha_fin' => $fechaFin,
                    ]
                ];
            })->toArray();
            
            $user->membresias()->sync($pivoteData);
        }

        // 8. Asignar 2 a 4 Productos aleatorios a CADA Venta.
        foreach ($ventas as $venta) {
            // Asignamos productos con datos pivote (cantidad y precio_unitario)
            $productosParaVenta = $productos->random(rand(2, 4))->mapWithKeys(function ($producto) {
                $cantidad = rand(1, 5); 
                $precioUnitario = $producto->precio; 

                return [
                    $producto->id => [
                        'cantidad' => $cantidad,
                        'precio_unitario' => $precioUnitario,
                    ]
                ];
            })->toArray();
            
            $venta->productos()->sync($productosParaVenta);
            
            // Recalcular el total de la venta
            $nuevoTotal = collect($productosParaVenta)->sum(function ($pivote) {
                return $pivote['cantidad'] * $pivote['precio_unitario'];
            });
            $venta->total = $nuevoTotal;
            $venta->save();
        }
    }
}
