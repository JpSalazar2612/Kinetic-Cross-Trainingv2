<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ServicioResource;
use App\Http\Resources\ServicioCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\StoreServiciosRequest;
use App\Http\Requests\UpdateServiciosRequest;

use App\Models\Servicio;
use App\Models\Membresia;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

 
class ServicioController extends Controller
{
    use AuthorizesRequests;

    /**
     * Muestra una lista de todos los servicios.
     */
        /**
     * @OA\Get(
     *    path="/api/servicios",
     *    summary="Consultar todos los servicios",
     *    description="Retorna todos los servicios",
     *    tags={"Servicios"},
     *    security={{"bearer_token":{}}},
     *    @OA\Response(
     *       response=200,
     *      description="Operación exitosa",
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="No autorizado"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="No se encontraron servicios"
     *   ),
     *   @OA\Response(
     *    response=405,
     *    description="Método no permitido"
     *   )
     * )
     */
    public function index()
    {
        $this->authorize('Ver servicios');
        
        $servicios = Servicio::with(['membresia'])->paginate(10); 
        
        return new ServicioCollection($servicios);
    }

     /**
     * @OA\Get(
     *    path="/api/servicios/{id}",
     *    summary="Consultar un servicio por ID",
     *    description="Retorna un servicio específica",
     *    tags={"Servicios"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID del servicio",
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="Operación exitosa",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="servicio no encontrada"
     *    ),
     *    @OA\Response(
     *      response=405,
     *      description="Método no permitido"
     *    )
     * )
     */
    public function show(Servicio $servicio)
    {
        return new ServicioResource($servicio);
    }

  /**
     * @OA\Post(
     *    path="/api/servicios",
     *    summary="Crear un nuevo servicio",
     *    description="Registra un nuevo servicio, asociado a una membresía existente.",
     *    tags={"Servicios"},
     *    security={{"bearer_token":{}}},
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *             required={"membresia_id", "nombre", "precio", "duracion_minutos"},
     *             @OA\Property(
     *                 property="membresia_id",
     *                 type="integer",
     *                 description="ID de la membresía a la que pertenece el servicio",
     *                 example=1
     *             ),
     *             @OA\Property(property="nombre", type="string", example="Clase de Spinning"),
     *             @OA\Property(
     *                 property="precio", 
     *                 type="number", 
     *                 format="float", 
     *                 description="Precio del servicio (si no está incluido en la membresía)",
     *                 example="10.50"
     *             ),
     *             @OA\Property(
     *                 property="duracion_minutos", 
     *                 type="integer", 
     *                 example="60"
     *             ),
     *             @OA\Property(property="tipo", type="string", example="Clase"),
     *             @OA\Property(property="detalles", type="string", example="Sesión de 1 hora de ciclismo indoor con instructor certificado."),
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *       response=201,
     *       description="Servicio creado",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=422,
     *       description="Error de validación (e.g., membresia_id no existe)"
     *    )
     * )
     */

    public function store(StoreServiciosRequest $request)
    {
        $this->authorize('Crear servicios');
        
        $servicio = Servicio::create($request->validated()); 
        
        return (new ServicioResource($servicio))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED); 
    }

    /**
     * @OA\Put(
     *    path="/api/servicios/{id}",
     *    summary="Actualizar un servicio",
     *    description="Actualiza un servicio existente por su ID.",
     *    tags={"Servicios"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID del servicio a actualizar",
     *        @OA\Schema(type="integer", example=1)
     *    ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *             required={"_method", "membresia_id", "nombre", "precio", "duracion_minutos"},
     *             @OA\Property(property="_method", type="string", description="Debe ser 'PUT' o 'PATCH'", example="PUT"),
     *             @OA\Property(
     *                 property="membresia_id",
     *                 type="integer",
     *                 description="ID de la membresía a la que pertenece el servicio",
     *                 example=2
     *             ),
     *             @OA\Property(property="nombre", type="string", example="Clase de Yoga Avanzada"),
     *             @OA\Property(
     *                 property="precio", 
     *                 type="number", 
     *                 format="float", 
     *                 description="Precio del servicio",
     *                 example="15.00"
     *             ),
     *             @OA\Property(
     *                 property="duracion_minutos", 
     *                 type="integer", 
     *                 example="90"
     *             ),
     *             @OA\Property(property="tipo", type="string", example="Clase Premium"),
     *             @OA\Property(property="detalles", type="string", example="Clase especial de 90 minutos de yoga."),
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="Servicio actualizado",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Servicio no encontrado"
     *    ),
     *    @OA\Response(
     *       response=422,
     *       description="Error de validación"
     *    )
     * )
     */
    public function update(UpdateServiciosRequest $request, Servicio $servicio)
    {
        $this->authorize('Actualizar servicios');
        
        $servicio->update($request->validated());
        
        return (new ServicioResource($servicio))
            ->response()
            ->setStatusCode(Response::HTTP_OK); 
    }
    /**
     * @OA\Put(
     *    path="/api/servicios/{id}",
     *    summary="Actualizar un servicio",
     *    description="Actualiza un servicio existente por su ID.",
     *    tags={"Servicios"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID del servicio a actualizar",
     *        @OA\Schema(type="integer", example=1)
     *    ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *             required={"_method", "membresia_id", "nombre", "precio", "duracion_minutos"},
     *             @OA\Property(property="_method", type="string", description="Debe ser 'PUT' o 'PATCH'", example="PUT"),
     *             @OA\Property(
     *                 property="membresia_id",
     *                 type="integer",
     *                 description="ID de la membresía a la que pertenece el servicio",
     *                 example=2
     *             ),
     *             @OA\Property(property="nombre", type="string", example="Clase de Yoga Avanzada"),
     *             @OA\Property(
     *                 property="precio", 
     *                 type="number", 
     *                 format="float", 
     *                 description="Precio del servicio",
     *                 example="15.00"
     *             ),
     *             @OA\Property(
     *                 property="duracion_minutos", 
     *                 type="integer", 
     *                 example="90"
     *             ),
     *             @OA\Property(property="tipo", type="string", example="Clase Premium"),
     *             @OA\Property(property="detalles", type="string", example="Clase especial de 90 minutos de yoga."),
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="Servicio actualizado",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Servicio no encontrado"
     *    ),
     *    @OA\Response(
     *       response=422,
     *       description="Error de validación"
     *    )
     * )
     */
    /**
     * @OA\Delete(
     *    path="/api/servicios/{id}",
     *    summary="Eliminar un servicio",
     *    description="Elimina un servicio existente por su ID.",
     *    tags={"Servicios"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID del servicio a eliminar",
     *        @OA\Schema(type="integer", example=1)
     *    ),
     *    @OA\Response(
     *       response=204,
     *       description="Servicio eliminado (No Content)"
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Servicio no encontrado"
     *    )
     * )
     */
    public function destroy(Servicio $servicio)
    {
        $this->authorize('Eliminar servicios');
        
        $servicio->delete();
        
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
