<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use App\Models\User;
use App\Models\Membresia;
use App\Models\Servicio; // Asegúrate de que este modelo exista y sea correcto
use App\Models\Producto;
use App\Models\Venta;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);
uses(WithFaker::class);

test('index', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));  // Simula un usuario autenticado
    
    // CORRECCIÓN: Crear una Membresia primero para que el Servicio sea válido
    Membresia::factory()->create(); 
    Servicio::factory()->count(3)->create();  // Crear 3 servicios de prueba

    $response = $this->getJson('/api/servicios');  // Realiza una solicitud GET a la ruta /api/servicios

    $response->assertStatus(Response::HTTP_OK)  // Verificar que el estado de la respuesta sea 200 OK
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'nombre',
                    'precio',
                    'tipo', 
                    'detalles', // Se cambió 'descripcion' por 'detalles' según tu estructura
                ]
            ]
        ]);
});


test('show', function () {  // Muestra un servicio específico
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));  // Simula un usuario autenticado
    Membresia::factory()->create(); 
    $servicio = Servicio::factory()->create(); // Crear un servicio

    $response = $this->getJson("/api/servicios/{$servicio->id}");  // Realiza una solicitud GET

    $response->assertStatus(Response::HTTP_OK)  // Verificar que el estado de la respuesta sea 200 OK
        ->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'precio',
                'tipo', 
                'detalles', // Se cambió 'descripcion' por 'detalles' según tu estructura
            ]
        ]);
});

test('store', function () {  // Crea un nuevo servicio
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));  // Simula un usuario autenticado

    Servicio::factory()->create();
    Membresia::factory()->create(); 
    
    $membresia = Membresia::factory()->create(); // Obtener la membresía creada
    $servicio = Servicio::factory()->create(); 

    $data = [  // Datos del nuevo servicio
            'id '=> $servicio->id,
            'membresia_id' => $membresia->id, // Usamos el ID de la membresía recién creada
            'nombre' => $this->faker->unique()->word(),
            'precio' => $this->faker->randomFloat(2, 0, 1000), 
            'tipo' => $this->faker->randomElement(['Clase', 'Taller', 'Sesión']), // Asumiendo tipos válidos
            'detalles' => $this->faker->sentence(),
            'duracion_minutos' => $this->faker->numberBetween(30, 240),
    ];

    $response = $this->postJson('/api/servicios', $data);  // Realiza una solicitud POST
    //dd($response->json()); // Línea clave si da error 500

    $response->assertStatus(Response::HTTP_CREATED);  // Verificar que el estado de la respuesta sea 201 Created

    // Verificar que se haya creado el registro
    $this->assertDatabaseHas('servicios', [
            'membresia_id' => $membresia->id,
            'nombre' => $data['nombre'],
            'precio' => $data['precio'],
            'tipo' => $data['tipo'],
            'detalles' => $data['detalles'],
            'duracion_minutos' => $data['duracion_minutos'],
    ]);
});

test('update', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Editor'));  // Simula un usuario autenticado

    Membresia::factory()->create(); 
    Servicio::factory()->create();
    $membresia = Membresia::factory()->create();
    $servicio = Servicio::factory()->create();  // Crear un servicio de prueba existente

    // CORRECCIÓN: Crear otra Membresia si quieres cambiar la relación en el update
    $membresia = Membresia::factory()->create(); 

    $data = [
        'id' => $servicio->id,
        'membresia_id' => $membresia->id, // Intentar cambiar la membresía
        'nombre' => 'Nombre del Servicio Actualizado', // Usar un nombre fijo y descriptivo
        'precio' => 199.99,
        'tipo' => 'Taller Avanzado',
        'detalles' => 'Detalles actualizados de prueba', 
        'duracion_minutos' => 120,
    ];

    $response = $this->putJson("/api/servicios/{$servicio->id}", $data);  // Realiza una solicitud PUT
    //dd($response->json());

    $response->assertStatus(Response::HTTP_OK);  // Verificar que el estado de la respuesta sea 200 OK

    // CORRECCIÓN CLAVE: Verificar la tabla y los campos correctos (servicios, nombre, precio, etc.)
    $this->assertDatabaseHas('servicios', [
        'id' => $servicio->id,
        'membresia_id' => $membresia->id,
        'nombre' => 'Nombre del Servicio Actualizado',
        'precio' => 199.99,
        'tipo' => 'Taller Avanzado',
        'detalles' => 'Detalles actualizados de prueba',
        'duracion_minutos' => 120,
    ]);
});


test('destroy', function () {  // Elimina un servicio
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));  // Simula un usuario autenticado

    Membresia::factory()->create(); 
    $servicio = Servicio::factory()->create();  // Crear un servicio

    $response = $this->deleteJson("/api/servicios/{$servicio->id}");  // CORRECCIÓN: Corregir la URL (asegurar el slash)

    $response->assertStatus(Response::HTTP_NO_CONTENT);  // Verificar que el estado de la respuesta sea 204 No Content

    // CORRECCIÓN CLAVE: Verificar que el ID del servicio se ha eliminado.
    $this->assertDatabaseMissing('servicios', [
        'id' => $servicio->id,
    ]);
});

test('destroy_editor', function () {  // Intenta eliminar una receta con un usuario con rol Editor
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);  // Ejecuta el seeder de roles

    Sanctum::actingAs(User::factory()->create()->assignRole('Editor'));  // Simula un usuario autenticado

    Membresia::factory()->create(); 
    $servicio = Servicio::factory()->create();  // Crear un servicio

    // CORRECCIÓN CLAVE: Corregir la URL
    $response = $this->deleteJson("/api/servicios/{$servicio->id}");  

    $response->assertStatus(Response::HTTP_FORBIDDEN);  // Verificar que el estado de la respuesta sea 403 Forbidden
});