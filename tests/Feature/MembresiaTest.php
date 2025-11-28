<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

use App\Models\User;
use App\Models\Membresia;
use App\Models\Servicios;
use App\Models\Producto;
use App\Models\Venta;
use Laravel\Sanctum\Sanctum;

// Usamos RefreshDatabase y WithFaker
uses(RefreshDatabase::class);
uses(WithFaker::class);

    Sanctum::actingAs(User::factory()->create()->assignRole('Editor')); 

    // Crear una membresia de prueba
    $membresia = Membresia::factory()->create(); 

    // --- CORRECCIÓN CLAVE para Update ---
    // Se utilizan valores nuevos y completos para la prueba PUT.
    $data = [
        'nombre' => 'Membresía Actualizada',
        'tipo' => 'Anual',
        'costo' => 499.99,
        'detalles' => 'Descripción actualizada de la membresía.',
        'duracion_dias' => 365,
    ];

    // Realiza una solicitud PUT (o PATCH si usas la ruta parcial)
    $response = $this->putJson("/api/membresias/{$membresia->id}", $data); 
    //dd($response->json()); // Descomenta si necesitas depurar

    // Verificar que el estado de la respuesta sea 200 OK
    $response->assertStatus(Response::HTTP_OK); 

    // Verificar que se haya actualizado el registro en la base de datos
    $this->assertDatabaseHas('membresias', [
        'id' => $membresia->id,
        'nombre' => $data['nombre'],
        'tipo' => $data['tipo'],
        'costo' => $data['costo'],
        'detalles' => $data['detalles'],
        'duracion_dias' => $data['duracion_dias'],
    ]);
});


test('destroy', function () { 
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // Simula un usuario autenticado con el rol de Administrador
    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador')); 

    // Crear una membresía
    $membresia = Membresia::factory()->create(); 

    // Realiza una solicitud DELETE
    $response = $this->deleteJson("/api/membresias/{$membresia->id}"); 

    // Verificar que el estado de la respuesta sea 200 OK (o 204 No Content, dependiendo de tu controlador)
    $response->assertStatus(Response::HTTP_NO_CONTENT); 

    // Verificar que se haya eliminado el registro
    $this->assertDatabaseMissing('membresias', ['id' => $membresia->id]);
});

test('destroy_editor', function () { 
    $this->artisan('db:seed', ['--class' => 'RolSeeder']); 

    // Simula un usuario autenticado con el rol de Editor
    Sanctum::actingAs(User::factory()->create()->assignRole('Editor')); 

    // Crear una membresía
    $membresia = Membresia::factory()->create(); 

    // Realiza una solicitud DELETE
    $response = $this->deleteJson("/api/membresias/{$membresia->id}"); 

    // Verificar que el estado de la respuesta sea 403 Forbidden
    $response->assertStatus(Response::HTTP_FORBIDDEN); 
});
test('index', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // Simula un usuario autenticado con el rol de Usuario
    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario')); 

    // Crear 3 membresias de prueba
    Membresia::factory()->count(3)->create(); 

    // Realiza una solicitud GET
    $response = $this->getJson('/api/membresias'); 

    // Verificar que el estado de la respuesta sea 200 OK
    $response->assertStatus(Response::HTTP_OK) 
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'nombre',
                    'tipo',
                    'costo',
                    'detalles',
                    'duracion_dias',
                ]
            ]
        ]);
});


test('show', function () { 
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // Simula un usuario autenticado con el rol de Usuario
    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario')); 
    
    // Crear una membresía
    $membresia = Membresia::factory()->create(); 

    // Realiza una solicitud GET
    $response = $this->getJson("/api/membresias/{$membresia->id}"); 
    //dd($response->json());

    // Verificar que el estado de la respuesta sea 200 OK
    $response->assertStatus(Response::HTTP_OK) 
        ->assertJsonStructure([
            'data' => [
           'id',
                    'nombre',
                    'tipo',
                    'costo',
                    'detalles',
                    'duracion_dias',
                ]
        ]);
});

test('store', function () { 
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // Simula un usuario autenticado con el rol de Administrador
    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador')); 

    // --- CORRECCIÓN CLAVE para evitar el error 422 ---
    // Definimos los datos explícitamente, asegurando que todos los campos 'required' estén presentes.
    $data = [
        'nombre' => 'Membresía Prueba Única',
        'tipo' => 'Mensual',
        'costo' => 49.99,
        'detalles' => 'Descripción de la membresía de prueba.',
        'duracion_dias' => 30,
    ];
    
    // Realiza una solicitud POST a la ruta /api/membresias/
    $response = $this->postJson('/api/membresias/', $data);
    
    //dd($response->json()); // Descomenta si necesitas depurar

    // Verificar que el estado de la respuesta sea 201 Created
    $response->assertStatus(Response::HTTP_CREATED) 
             ->assertJsonStructure([
                 'data' => [
                     'id',
                     'nombre',
                    'tipo',
                    'costo',
                    'detalles',
                    'duracion_dias',
                 ]
             ])
             // Opcional: Verifica que los datos retornados coincidan
             ->assertJsonPath('data.nombre', $data['nombre']);

    // Verificar que el registro se haya creado correctamente en la base de datos
    $this->assertDatabaseHas('membresias', [
        'nombre' => $data['nombre'],
        'tipo' => $data['tipo'],
        'costo' => $data['costo'],
        'detalles' => $data['detalles'],
        'duracion_dias' => $data['duracion_dias'],
    ]);
});

test('update', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    // Simula un usuario autenticado con el rol de Editor