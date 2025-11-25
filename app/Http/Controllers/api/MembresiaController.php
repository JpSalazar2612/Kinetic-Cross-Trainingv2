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

class MembresiaController extends Controller
{
    use AuthorizesRequests;
     public function index(){
        //$membresia = Membresia::all();
        //return new MembresiaCollection($membresia);
    $this->authorize ('Ver membresias');
    $membresia = Membresia::with (['users', 'servicios', 'ventas'])->get(); 
    return MembresiaResource::collection($membresia);
    // El Collection se encarga de aplicar el Resource a cada elemento.
    //return new MembresiaCollection($membresia);

}
    public function show($id){
        $this ->authorize('Ver membresias');
        $membresia = Membresia::find($id);
        if ($membresia) {
            return new MembresiaResource($membresia);
        } else {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }
    }
   public function store(StoreMembresiasRequest $request) // <-- Usa StoreMembresiasRequest
{
    $membresia = Membresia::create($request->validated());

    return (new MembresiaResource($membresia))
        ->response()
        ->setStatusCode(201);
}
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
    public function destroy($id){
        $this->authorize('Eliminar membresias');
        $membresia = Membresia::find($id);
        if ($membresia) {
            $membresia->delete();
            return response()->json(['message' => 'Membresía eliminada correctamente'], 200);
        } else {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }
    }
}
