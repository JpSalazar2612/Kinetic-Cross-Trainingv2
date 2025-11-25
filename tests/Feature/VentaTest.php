<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use App\Models\User;
use App\Models\Membresia; 
use App\Models\Servicio;
use App\Models\Producto;
use App\Models\Venta;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);
uses(WithFaker::class);

test('index', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));  // Simula un usuario autenticado con el rol de Usuario

    Venta::factory(3)->create();  // Crear 3 recetas

    $response = $this->getJson('/api/ventas');  // Realiza una solicitud GET a la ruta /api/recetas
    //dd($response->json());  // Mostrar la respuesta JSON para depuración

    $response->assertStatus(Response::HTTP_OK)  // Verificar que el estado de la respuesta sea 200 OK
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                [
                   'id',
                'user_id',
                'membresia_id',
                'total',
                    ]  
            ]
        ]);
});


test('show', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // 1. Crear y autenticar al usuario
    $user = User::factory()->create()->assignRole('Usuario');
    Sanctum::actingAs($user);

    // Crear una venta ligada al usuario
    $venta = Venta::factory()->create(['user_id' => $user->id]); 

    // Realiza una solicitud GET a la ruta /api/ventas/{id}
    $response = $this->getJson("/api/ventas/{$venta->id}");

    // Verificar que el estado de la respuesta sea 200 OK
    $response->assertStatus(Response::HTTP_OK)
        // Se verifican los campos en camelCase
        ->assertJsonStructure([
            'data' => [
                'id',
                'user_id',
                'membresia_id',
                'total',
                'fecha_venta', 
                'metodo_pago', 
            ]
        ]);
});

test('store', function () {
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    $user = User::factory()->create()->assignRole('Administrador');
    Sanctum::actingAs($user);
    
    // Asegurarse de que exista una membresía para la FK
    $membresia = Membresia::factory()->create();

    $data = [
        'membresia_id' => $membresia->id, 
        'total' => $this->faker->randomFloat(2, 50, 500),
        'fecha_venta' => $this->faker->date(), 
        'metodo_pago' => $this->faker->randomElement(['Tarjeta', 'Efectivo', 'Transferencia']),
    ];

    $response = $this->postJson('/api/ventas', $data);

    $response->assertStatus(Response::HTTP_CREATED); 

    // Verificar que se haya creado el registro en la base de datos.
    // CORRECCIÓN 2: Se ajusta el valor de 'fecha_venta' para incluir la hora '00:00:00' 
    // ya que Laravel lo guarda en formato DATETIME en la DB.
    $this->assertDatabaseHas('ventas', [
        'user_id' => $user->id, 
        'membresia_id' => $data['membresia_id'],
        'total' => $data['total'],
        'fecha_venta' => $data['fecha_venta'] . ' 00:00:00', // Añado la hora
        'metodo_pago' => $data['metodo_pago'],
    ]);
});

test('update', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    $user = User::factory()->create()->assignRole('Editor');
    Sanctum::actingAs($user);

    // Crear una venta inicial ligada al usuario
    $venta = Venta::factory()->create(['user_id' => $user->id]); 
    $membresiaNueva = Membresia::factory()->create(); // Crear nueva membresía para el cambio

    $data = [
        'membresia_id' => $membresiaNueva->id, 
        'total' => $this->faker->randomFloat(2, 500, 1000), 
        'fecha_venta' => '2030-01-01', 
        'metodo_pago' => 'Transferencia', 
    ];

    // Realiza una solicitud PUT a la ruta /api/ventas/{id}
    $response = $this->putJson("/api/ventas/{$venta->id}", $data);

    $response->assertStatus(Response::HTTP_OK); 

    // Verificar que se haya actualizado el registro
    // CORRECCIÓN 3: Se ajusta el valor de 'fecha_venta' para incluir la hora '00:00:00'
    $this->assertDatabaseHas('ventas', [
        'id' => $venta->id,
        'user_id' => $user->id, 
        'membresia_id' => $data['membresia_id'],
        'total' => $data['total'],
        'fecha_venta' => $data['fecha_venta'] . ' 00:00:00', // Añado la hora
        'metodo_pago' => $data['metodo_pago'],
    ]);
});


test('destroy', function () {
    // Elimina una venta
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // Simula un usuario autenticado con el rol de Administrador
    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));

    $venta = Venta::factory()->create(); // Crear una venta

    // Realiza una solicitud DELETE a la ruta /api/ventas/{id}
    $response = $this->deleteJson("/api/ventas/{$venta->id}");

    $response->assertStatus(Response::HTTP_OK); 

    // Verificar que se haya eliminado el registro
    $this->assertDatabaseMissing('ventas', [
        'id' => $venta->id,
    ]);
});

test('destroy_editor', function () {
    // Intenta eliminar una venta con un usuario con rol Editor
    $this->artisan('db:seed', ['--class' => 'RolSeeder']); 

    // Simula un usuario autenticado con el rol de Editor
    Sanctum::actingAs(User::factory()->create()->assignRole('Editor'));

    $venta = Venta::factory()->create(); // Crear una venta
    
    // Realiza una solicitud DELETE a la ruta /api/ventas/{id}
    $response = $this->deleteJson("/api/ventas/{$venta->id}");

    // Verificar que el estado de la respuesta sea 403 Forbidden (el Editor no puede borrar)
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});