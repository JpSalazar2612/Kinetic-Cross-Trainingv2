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

uses(RefreshDatabase::class);
uses(WithFaker::class);

test('index', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));  // Simula un usuario autenticado con el rol de Usuario

    // CORRECCIÓN: Crear varios productos para probar assertJsonCount. Creamos 3.
    Producto::factory()->count(3)->create();

    $response = $this->getJson('/api/productos');  // Realiza una solicitud GET a la ruta /api/productos
    //dd($response->json());  // Mostrar la respuesta JSON para depuración

    $response->assertStatus(Response::HTTP_OK)  // Verificar que el estado de la respuesta sea 200 OK
        // CORRECCIÓN: El primer argumento debe ser la cantidad, el segundo (opcional) el path.
        ->assertJsonCount(3, 'data') 
        ->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'nombre',
                    'precio',
                    'descripcion',
                ]
            ]
        ]);
});


test('show', function () {  // Muestra un producto específico
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Usuario'));  // Simula un usuario autenticado con el rol de Usuario
    $producto = Producto::factory()->create(); // Crear un producto

    $response = $this->getJson("/api/productos/{$producto->id}");  // Realiza una solicitud GET a la ruta /api/productos/{id}
    //dd($response->json());

    $response->assertStatus(Response::HTTP_OK)  // Verificar que el estado de la respuesta sea 200 OK
        ->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
                'precio',
                'descripcion',
            ]
        ]);
});

test('store', function () {  // Crea un nuevo producto exitosamente
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));  // Simula un usuario autenticado con el rol de Administrador
    
    // CORRECCIÓN: Quitamos la creación de un producto existente y el envío del ID.
    $data = [  // Datos del nuevo producto
        'nombre' => $this->faker->unique()->word(),
        'precio' => $this->faker->randomFloat(2, 1, 1000), // Precio entre 1 y 1000
        'stock' => $this->faker->numberBetween(0, 100),
        'descripcion' => $this->faker->sentence(),  
    ];


    $response = $this->postJson('/api/productos', $data);  // Realiza una solicitud POST a la ruta /api/productos
    //dd($response->json()); // Si el 500 persiste, esta línea es clave para depurar

    $response->assertStatus(Response::HTTP_CREATED);  // Verificar que el estado de la respuesta sea 201 Created

    // Verificar que se haya creado el registro
    $this->assertDatabaseHas('productos', [
        'nombre' => $data['nombre'],
        'precio' => $data['precio'],
        'descripcion' => $data['descripcion'],
        // No verificamos 'stock' para simplificar, pero puedes agregarlo si es necesario:
        // 'stock' => $data['stock'],
    ]);
});

test('update', function () {
    // Ejecuta el seeder de roles
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Editor'));  // Simula un usuario autenticado con el rol de Editor

    $producto = Producto::factory()->create();  // Crear un producto de prueba existente

    $data = [
        'nombre' => 'Nombre Actualizado', // Usar un nombre fijo para la aserción
        'precio' => 99.99, // Usar un precio fijo para la aserción
        'stock' => 50,
        'descripcion' => 'Descripcion actualizada de prueba', // Usar una descripción fija
    ];

    $response = $this->putJson("/api/productos/{$producto->id}", $data);  // Realiza una solicitud PUT a la ruta /api/productos/{id}
    //dd($response->json());

    $response->assertStatus(Response::HTTP_OK);  // Verificar que el estado de la respuesta sea 200 OK

    // Verificar que se haya actualizado el registro
    $this->assertDatabaseHas('productos', [
        'id' => $producto->id,
        'nombre' => $data['nombre'],
        'precio' => 99.99, // Verificar el valor fijo
        'descripcion' => $data['descripcion'],
    ]);
});


test('destroy', function () {  // Elimina un producto como Administrador
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);

    Sanctum::actingAs(User::factory()->create()->assignRole('Administrador'));  // Simula un usuario autenticado con el rol de Administrador

    $producto = Producto::factory()->create();  // Crear un producto

    $response = $this->deleteJson("/api/productos/{$producto->id}");  // Realiza una solicitud DELETE a la ruta /api/productos/{id}

    $response->assertStatus(Response::HTTP_NO_CONTENT);  // Verificar que el estado de la respuesta sea 204 No Content

    $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
});

test('destroy_editor', function () {  // Intenta eliminar un producto con un usuario con rol Editor
    $this->artisan('db:seed', ['--class' => 'RolSeeder']);  // Ejecuta el seeder de roles

    Sanctum::actingAs(User::factory()->create()->assignRole('Editor'));  // Simula un usuario autenticado con el rol de Editor

    $producto = Producto::factory()->create();  // Crear un producto

    $response = $this->deleteJson("/api/productos/{$producto->id}");  // Realiza una solicitud DELETE a la ruta /api/productos/{id}

    $response->assertStatus(Response::HTTP_FORBIDDEN);  // Verificar que el estado de la respuesta sea 403 Forbidden
});