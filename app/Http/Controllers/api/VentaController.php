<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\VentaResource; 
use App\Http\Resources\VentaCollection; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;

use App\Http\Requests\StoreVentasRequest;
use App\Http\Requests\UpdateVentasRequest;

// Imports corregidos
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class VentaController extends Controller
{
    // Uso del trait AuthorizesRequests para que funcione $this->authorize()
    use AuthorizesRequests;

    // **********************************************
    // MÉTODOS EXISTENTES (Index, Show)
    // **********************************************

    /**
    * @OA\Get(
    * path="/api/ventas",
    * summary="Consultar todas las ventas",
    * description="Retorna todas las ventas",
    * tags={"Ventas"},
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
    * description="No se encontraron ventas"
    * ),
    * @OA\Response(
    * response=405,
    * description="Método no permitido"
    * )
    * )
    */
    public function index(){
        $this->authorize ('Ver ventas');
        $ventas = Venta::with(['user', 'membresia'])->get(); 
        return new VentaCollection($ventas);
    }
    
    /**
    * @OA\Get(
    * path="/api/ventas/{id}",
    * summary="Consultar una venta por ID",
    * description="Retorna los detalles de una venta específica, incluyendo el usuario y la membresía asociada (si aplica).",
    * tags={"Ventas"},
    * security={{"bearer_token":{}}},
    * @OA\Parameter(
    * name="id",
    * in="path",
    * required=true,
    * description="ID de la venta a consultar",
    * @OA\Schema(
    * type="integer",
    * format="int64",
    * example=1
    * )
    * ),
    * @OA\Response(
    * response=200,
    * description="Operación exitosa",
    * @OA\JsonContent(
    * @OA\Property(property="id", type="integer", example=1, description="ID único de la venta"),
    * @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que realizó la venta"),
    * @OA\Property(property="membresia_id", type="integer", nullable=true, example=2, description="ID de la membresía asociada (puede ser null)"),
    * @OA\Property(property="total", type="number", format="float", example=150.00, description="Monto total de la venta"),
    * @OA\Property(property="fecha_venta", type="string", format="date", example="2025-11-25", description="Fecha de la venta"),
    * @OA\Property(property="metodo_pago", type="string", example="Tarjeta", description="Método de pago (ej: Tarjeta, Efectivo)"),
    * @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-25T14:00:00.000000Z"),
    * @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-25T14:00:00.000000Z")
    * )
    * ),
    * @OA\Response(
    * response=401,
    * description="No autenticado"
    * ),
    * @OA\Response(
    * response=403,
    * description="No autorizado"
    * ),
    * @OA\Response(
    * response=404,
    * description="Venta no encontrada"
    * )
    * )
    */
    public function show($id){
        $this ->authorize('Ver ventas');
        $venta = Venta::with(['user', 'membresia'])->find($id); 
        
        if ($venta) {
            return new VentaResource($venta);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], Response::HTTP_NOT_FOUND); 
        }
    }
    
    // **********************************************
    // MÉTODOS AÑADIDOS (Store, Update, Destroy)
    // **********************************************
    
   /**
 * @OA\Post(
 * path="/api/ventas",
 * summary="Crear una nueva venta",
 * description="Crea un nuevo registro de venta. Requiere autenticación con token Bearer.",
 * tags={"Ventas"},
 * security={{"bearer_token":{}}},
 * @OA\RequestBody(
 * required=true,
 * description="Datos de la venta a crear",
 * @OA\JsonContent(
 * required={"user_id", "total", "fecha_venta", "metodo_pago"},
 * @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que realiza la venta"),
 * @OA\Property(property="membresia_id", type="integer", nullable=true, example=2, description="ID de la membresía asociada (Opcional)"),
 * @OA\Property(property="total", type="number", format="float", example=150.00, description="Monto total de la venta"),
 * @OA\Property(property="fecha_venta", type="string", format="date", example="2025-11-25", description="Fecha de la venta (YYYY-MM-DD)"),
 * @OA\Property(property="metodo_pago", type="string", example="Tarjeta", description="Método de pago (ej: Tarjeta, Efectivo)")
 * )
 * ),
 * @OA\Response(
 * response=201,
 * description="Venta creada exitosamente",
 * @OA\JsonContent(
 * @OA\Property(property="id", type="integer", example=1, description="ID único de la venta"),
 * @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que realizó la venta"),
 * @OA\Property(property="membresia_id", type="integer", nullable=true, example=2, description="ID de la membresía asociada (puede ser null)"),
 * @OA\Property(property="total", type="number", format="float", example=150.00, description="Monto total de la venta"),
 * @OA\Property(property="fecha_venta", type="string", format="date", example="2025-11-25", description="Fecha de la venta"),
 * @OA\Property(property="metodo_pago", type="string", example="Tarjeta", description="Método de pago"),
 * @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-25T14:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-25T14:00:00.000000Z")
 * )
 * ),
 * @OA\Response(response=422, description="Datos de validación incorrectos"),
 * @OA\Response(response=401, description="No autenticado")
 * )
 */
    public function store(StoreVentasRequest $request){
        $this->authorize('Crear ventas');

        $validatedData = $request->validated();
        
        // Asignar el user_id del usuario autenticado (si no se envía en el request)
        if (!isset($validatedData['user_id'])) {
            $validatedData['user_id'] = $request->user()->id; 
        }
        
        $venta = Venta::create($validatedData);

        return (new VentaResource($venta))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED); // 201 Created
    }
    
   /**
 * @OA\Put(
 * path="/api/ventas/{id}",
 * summary="Actualizar una venta por ID",
 * description="Actualiza los datos de una venta existente. Requiere autenticación con token Bearer.",
 * tags={"Ventas"},
 * security={{"bearer_token":{}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID de la venta a actualizar",
 * @OA\Schema(type="integer")
 * ),
 * @OA\RequestBody(
 * required=true,
 * description="Campos de la venta a actualizar",
 * @OA\JsonContent(
 * @OA\Property(property="membresia_id", type="integer", nullable=true, example=null, description="ID de la membresía asociada (Opcional)"),
 * @OA\Property(property="total", type="number", format="float", example=160.00, description="Nuevo monto total"),
 * @OA\Property(property="fecha_venta", type="string", format="date", example="2025-11-26", description="Nueva fecha de la venta"),
 * @OA\Property(property="metodo_pago", type="string", example="Transferencia", description="Nuevo método de pago")
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="Venta actualizada exitosamente",
 * @OA\JsonContent(
 * @OA\Property(property="id", type="integer", example=1, description="ID único de la venta"),
 * @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que realizó la venta"),
 * @OA\Property(property="membresia_id", type="integer", nullable=true, example=2, description="ID de la membresía asociada (puede ser null)"),
 * @OA\Property(property="total", type="number", format="float", example=150.00, description="Monto total de la venta"),
 * @OA\Property(property="fecha_venta", type="string", format="date", example="2025-11-25", description="Fecha de la venta"),
 * @OA\Property(property="metodo_pago", type="string", example="Tarjeta", description="Método de pago"),
 * @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-25T14:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-25T14:00:00.000000Z")
 * )
 * ),
 * @OA\Response(response=404, description="Venta no encontrada"),
 * @OA\Response(response=422, description="Datos de validación incorrectos")
 * )
 */
    public function update(UpdateVentasRequest $request, $id){
        $this->authorize('Actualizar ventas');
        $venta = Venta::find($id);
        
        if ($venta) {
            $venta->update($request->validated()); 
            // Cargar relaciones antes de retornar el recurso, por si cambiaron los IDs
            $venta->load(['user', 'membresia']);
            return new VentaResource($venta);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], Response::HTTP_NOT_FOUND); // 404 Not Found
        }
    }

   /**
 * @OA\Delete(
 * path="/api/ventas/{id}",
 * summary="Eliminar una venta por ID",
 * description="Elimina permanentemente un registro de venta. Retorna 204 No Content en caso de éxito.",
 * tags={"Ventas"},
 * security={{"bearer_token":{}}},
 * @OA\Parameter(
 * name="id",
 * in="path",
 * required=true,
 * description="ID de la venta a eliminar",
 * @OA\Schema(type="integer")
 * ),
 * @OA\Response(
 * response=204,
 * description="Venta eliminada exitosamente (No Content)"
 * ),
 * @OA\Response(response=404, description="Venta no encontrada"),
 * @OA\Response(response=401, description="No autenticado")
 * )
 */
    public function destroy($id){
        $this->authorize('Eliminar ventas');
        $venta = Venta::find($id);
        
        if ($venta) {
            $venta->delete();
            // Respuesta 204 No Content para eliminación exitosa, sin cuerpo (body)
            return response()->json(null, Response::HTTP_NO_CONTENT); 
        } else {
            return response()->json(['message' => 'Venta no encontrada'], Response::HTTP_NOT_FOUND); // 404 Not Found
        }
    }
}