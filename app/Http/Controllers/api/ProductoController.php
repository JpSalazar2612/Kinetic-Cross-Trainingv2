<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ProductoResource;
use App\Http\Resources\ProductoCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; // ¡CORREGIDO: Uso de la clase de respuesta correcta!

use App\Models\Producto;

use App\Http\Requests\StoreProductosRequest;
use App\Http\Requests\UpdateProductosRequest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ProductoController extends Controller
{
    use AuthorizesRequests; // Uso correcto para `authorize()`

    /**
     * Muestra una lista de todos los productos.
     */
    public function index()
    {
        $this->authorize('Ver productos');
        
        // Uso de paginate() para buenas prácticas y coherencia con el test (3 productos creados)
        $producto = Producto::with(['ventas'])->paginate(10); 
        
        return new ProductoCollection($producto);
    }

    /**
     * Muestra un producto específico.
     * Usamos Route Model Binding (Producto $producto) para manejar el 404 automáticamente.
     */
    public function show(Producto $producto)
    {
        // No se necesita Producto::find($id); gracias al Route Model Binding.
        return new ProductoResource($producto);
    }

    /**
     * Crea un nuevo producto.
     */
    public function store(StoreProductosRequest $request)
    {
        $this->authorize('Crear productos');
        
        // CORRECCIÓN 1: Usamos $request->validated() para obtener los datos validados.
        // La validación ya se ejecutó automáticamente al inyectar StoreProductosRequest.
        $producto = Producto::create($request->validated()); 
        
        return (new ProductoResource($producto))
            ->response()
            // CORRECCIÓN 2: Usar la constante HTTP_CREATED para el estado 201.
            ->setStatusCode(Response::HTTP_CREATED); 
    }

    /**
     * Actualiza un producto existente.
     * Usamos Route Model Binding para manejar el 404 automáticamente.
     */
    public function update(UpdateProductosRequest $request, Producto $producto) // Usamos UpdateProductosRequest y Route Model Binding
    {
        $this->authorize('Actualizar productos');
        
        // CORRECCIÓN 3: Usamos $request->validated() para actualizar.
        // Si tienes un UpdateProductosRequest, úsalo aquí. Si solo tienes StoreProductosRequest, úsalo, pero la convención es crear uno de Update.
        $producto->update($request->validated());
        
        return (new ProductoResource($producto))
            ->response()
            // CORRECCIÓN 4: Devolver 200 OK
            ->setStatusCode(Response::HTTP_OK); 
    } 
    
    /**
     * Elimina un producto.
     * Usamos Route Model Binding para manejar el 404 automáticamente.
     */
    public function destroy(Producto $producto)
    {
        $this->authorize('Eliminar productos');
        
        $producto->delete();
        
        // CORRECCIÓN 5: Devolver 204 No Content para una eliminación exitosa sin cuerpo de respuesta.
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}