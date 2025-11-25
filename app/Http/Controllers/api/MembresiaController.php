<?php
namespace App\Http\Controllers\api;

use App\Http\Resources\MembresiaResource; // Importar el recurso CategoriaResource
use App\Http\Resources\MembresiaCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Membresia;

use App\Http\Requests\StoreMembresiasRequest;
use App\Http\Requests\UpdateMembresiasRequest;

use Symfony\Componets\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    /**
  * @OA\Info(
    *     title="Kinetick API REST con Laravel",
    *     version="1.0.0",
    *     @OA\Contact(
    *         email="Juan@cdhidalgo.tecnm.mx"
    *     )
    * )
    *@OA\Server(url="http://127.0.0.1:8000")
    */

class MembresiaController extends Controller
{
    use AuthorizesRequests;
    /**
 * Inicia sesión y genera un token de acceso.
 * @OA\Post(
 * path="/api/login",
 * summary="Generar Token de Acceso (Login)",
 * description="Autentica al usuario con correo, contraseña y dispositivo para obtener un token de acceso.",
 * tags={"Autenticación"},
 * @OA\RequestBody(
 * required=true,
 * @OA\JsonContent(
 * required={"correo", "contraseña", "dispositivo"},
 * @OA\Property(property="correo", type="string", format="email", example="Erwin@example.com", description="Correo del usuario."),
 * @OA\Property(property="contraseña", type="string", format="password", example="password", description="Contraseña del usuario."),
 * @OA\Property(property="dispositivo", type="string", example="windows", description="Nombre del dispositivo (e.g., 'windows', 'ios', 'android').")
 * )
 * ),
 * @OA\Response(
 * response=200,
 * description="Inicio de sesión exitoso. Retorna un token de acceso.",
 * @OA\JsonContent(
 * @OA\Property(property="data", type="object",
 * @OA\Property(property="attributes", type="object",
 * @OA\Property(property="id", type="integer", example=2),
 * @OA\Property(property="nombre", type="string", example="Erwin Santiago Arrega Avila"),
 * @OA\Property(property="correo", type="string", format="email", example="Erwin@example.com")
 * ),
 * @OA\Property(property="token", type="string", example="lkYTYtksh64dJh9bqKrFa5GHpQZax2IA9D8fdI7Rc54a30ac", description="Token de acceso JWT.")
 * )
 * )
 * ),
 * @OA\Response(
 * response=401,
 * description="Credenciales no válidas.",
 * @OA\JsonContent(
 * @OA\Property(property="message", type="string", example="Credenciales no válidas")
 * )
 * )
 * )
 */

    /**
     * @OA\Get(
     *    path="/api/membresias",
     *    summary="Consultar todas las membresias",
     *    description="Retorna todas las membresias",
     *    tags={"Membresias"},
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
     *     description="No se encontraron membresias"
     *   ),
     *   @OA\Response(
     *    response=405,
     *    description="Método no permitido"
     *   )
     * )
     */
     public function index(){
        //$membresia = Membresia::all();
        //return new MembresiaCollection($membresia);
    $this->authorize ('Ver membresias');
    $membresia = Membresia::with (['users', 'servicios', 'ventas'])->get(); 
    return MembresiaResource::collection($membresia);
    // El Collection se encarga de aplicar el Resource a cada elemento.
    //return new MembresiaCollection($membresia);

}
     
    /**
     * @OA\Get(
     *    path="/api/membresias/{id}",
     *    summary="Consultar una membresia por ID",
     *    description="Retorna una membresia específica",
     *    tags={"Membresias"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID de la membresía",
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
     *       description="Membresia no encontrada"
     *    ),
     *    @OA\Response(
     *      response=405,
     *      description="Método no permitido"
     *    )
     * )
     */
    public function show($id){
        $this ->authorize('Ver membresias');
        $membresia = Membresia::find($id);
        if ($membresia) {
            return new MembresiaResource($membresia);
        } else {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }
    }

    /**
     * @OA\Post(
     *    path="/api/membresias",
     *    summary="Crear membresias",
     *    description="Crear una nueva membresia",
     *    tags={"Membresias"},
     *    security={{"bearer_token":{}}},
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *             required={"nombre","tipo","costo", "detalles", "duracion_dias"},
     *             @OA\Property(property="nombre", type="string", example="Membresia Oro"),
     *             @OA\Property(property="tipo", type="string", example="Mensual"),
     *             @OA\Property(property="costo", type="number", format="float", example="49.99"),
     *             @OA\Property(property="detalles", type="string", example="Acceso completo a todas las instalaciones y clases."),
     *             @OA\Property(property="duracion_dias", type="integer", example="30"),
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *       response=201,
     *       description="Membresia creada",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    )
     * )
     */
   public function store(StoreMembresiasRequest $request) // <-- Usa StoreMembresiasRequest
{
    $membresia = Membresia::create($request->validated());

    return (new MembresiaResource($membresia))
        ->response()
        ->setStatusCode(201);
}
/**
     * @OA\Put(
     *    path="/api/membresias/{id}",
     *    summary="Actualizar membresias",
     *    description="Actualizar una membresia existente",
     *    tags={"Membresias"},
     *    security={{"bearer_token":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID de la membresía a actualizar",
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *          mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     * required={"_method", "nombre","tipo","costo", "detalles", "duracion_dias"},
     * @OA\Property(property="_method", type="string", description="Debe ser 'PUT' o 'PATCH'", example="PUT"),
     *             @OA\Property(property="nombre", type="string", example="Membresia Platino"),
     *             @OA\Property(property="tipo", type="string", example="Anual"),
     *             @OA\Property(property="costo", type="number", format="float", example="499.99"),
     *             @OA\Property(property="detalles", type="string", example="Acceso premium con entrenador personal y sauna."),
     *             @OA\Property(property="duracion_dias", type="integer", example="365"),
     *         )
     *       )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="Membresia actualizada",
     *    ),
     *    @OA\Response(
     *       response=403,
     *       description="No autorizado"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="Membresia no encontrada"
     *    ),
     *    @OA\Response(
     *       response=422,
     *       description="Error de validación"
     *    )
     * )
     */ 

   
   public function update(UpdateMembresiasRequest $request, $id) // <-- Usa UpdateMembresiaRequest
{
    $this->authorize('Actualizar membresias');
    // Usa Membresia (singular) en lugar de Membresias (como ya se corrigió antes)
    $membresia = Membresia::find($id); 

    if ($membresia) {
        // ... (Tu lógica de actualización)
        $membresia->update($request->validated());

        return (new MembresiaResource($membresia))
            ->response()
            ->setStatusCode(200); 
    } else {
        return response()->json(['message' => 'Membresía no encontrada'], 404);
    }
}
 /**
     * @OA\Delete(
     * path="/api/membresias/{id}",
     * summary="Eliminar membresia",
     * description="Elimina una membresía existente por su ID.",
     * tags={"Membresias"},
     * security={{"bearer_token":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID de la membresía a eliminar",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * example=1
     * )
     * ),
     * @OA\Response(
     * response=204,
     * description="Membresía eliminada correctamente (Sin Contenido)",
     * ),
     * @OA\Response(
     * response=403,
     * description="No autorizado"
     * ),
     * @OA\Response(
     * response=404,
     * description="Membresía no encontrada"
     * )
     * )
     */

    public function destroy($id){
        $this->authorize('Eliminar membresias');
        $membresia = Membresia::find($id);
        if ($membresia) {
            $membresia->delete();
            // Se cambió el código de respuesta de 200 a 204 No Content, que es estándar para DELETE
            return response()->json(null, 204); 
        } else {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }
    }
}

