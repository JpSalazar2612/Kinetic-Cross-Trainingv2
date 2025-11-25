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
         /**
     * @OA\Get(
     * path="/api/productos",
     * summary="Consultar todas los productos",
     * description="Retorna todas los productos",
     * tags={"Productos"},
     * security={{"bearer_token":{}}},
     * @OA\Response(
     * response=200,
     * description="Operación exitosa",
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado"
     * ),
     * @OA\Response(
     * response=404,
     * description="No se encontraron productos"
     * ),
     * @OA\Response(
     * response=405,
     * description="Método no permitido"
     * )
     * )
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
     * @OA\Get(
     * path="/api/productos/{producto}",
     * summary="Consultar un producto por ID",
     * description="Retorna un producto específico",
     * tags={"Productos"},
     * security={{"bearer_token":{}}},
     * @OA\Parameter(
     * name="producto",
     * in="path",
     * required=true,
     * description="ID del producto",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operación exitosa",
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado"
     * ),
     * @OA\Response(
     * response=404,
     * description="Producto no encontrado"
     * ),
     * @OA\Response(
     * response=405,
     * description="Método no permitido"
     * )
     * )
     */
    public function show(Producto $producto)
    {
        // No se necesita Producto::find($id); gracias al Route Model Binding.
        return new ProductoResource($producto);
    }
    /**
     * @OA\Post(
     * path="/api/productos",
     * summary="Crear productos",
     * description="Crear un nuevo producto ",
     * tags={"Productos"},
     * security={{"bearer_token":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"nombre", "descripcion", "precio", "stock"},
     * @OA\Property(property="nombre", type="string", description="Nombre del producto", example="Producto A"),
     * @OA\Property(property="descripcion", type="string", description="Descripción del producto", example="Descripción del Producto A"),
     * @OA\Property(property="precio", type="number", format="float", description="Precio del producto", example="19.99"),
     * @OA\Property(property="stock", type="integer", description="Cantidad en stock del producto", example="100"),
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Producto creado",
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado"
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación"
     * )
     * )
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
     * @OA\Put(
     * path="/api/productos/{producto}",
     * summary="Actualizar un producto",
     * description="Actualiza un producto específico",
     * tags={"Productos"},
     * security={{"bearer_token":{}}},
     * @OA\Parameter(
     * name="producto",
     * in="path",
     * required=true,
     * description="ID del producto a actualizar",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="application/x-www-form-urlencoded",
     * @OA\Schema(
     * required={"_method", "nombre", "descripcion", "precio", "stock"},
     * @OA\Property(property="_method", type="string", description="Debe ser 'PUT' o 'PATCH'", example="PUT"),
     * @OA\Property(property="nombre", type="string", description="Nombre del producto", example="Producto B (Actualizado)"),
     * @OA\Property(property="descripcion", type="string", description="Descripción del producto", example="Descripción del Producto B (Actualizado)"),
     * @OA\Property(property="precio", type="number", format="float", description="Precio del producto", example="25.50"),
     * @OA\Property(property="stock", type="integer", description="Cantidad en stock del producto", example="50"),
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Producto actualizado exitosamente",
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado"
     * ),
     * @OA\Response(
     * response=404,
     * description="Producto no encontrado"
     * ),
     * @OA\Response(
     * response=422,
     * description="Error de validación"
     * )
     * )
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
     * @OA\Delete(
     * path="/api/productos/{producto}",
     * summary="Eliminar un producto",
     * description="Elimina un producto específico",
     * tags={"Productos"},
     * security={{"bearer_token":{}}},
     * @OA\Parameter(
     * name="producto",
     * in="path",
     * required=true,
     * description="ID del producto a eliminar",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=204,
     * description="Producto eliminado exitosamente (Sin contenido)",
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado"
     * ),
     * @OA\Response(
     * response=404,
     * description="Producto no encontrado"
     * )
     * )
     */
    public function destroy(Producto $producto)
    {
        $this->authorize('Eliminar productos');
        
        $producto->delete();
        
        // CORRECCIÓN 5: Devolver 204 No Content para una eliminación exitosa sin cuerpo de respuesta.
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}