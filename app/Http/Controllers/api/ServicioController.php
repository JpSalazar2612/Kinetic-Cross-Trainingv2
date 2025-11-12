<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ServicioResource; // Importar el recurso CategoriaResource
use App\Http\Resources\ServicioCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Servicio;

use App\Http\Requests\StoreServiciosRequest;
use App\Http\Requests\UpdateServiciosRequest;   

use Synfony\Componets\HttpFoundation\Response;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;    

class ServicioController extends Controller
{
    public function index(){
        $this->authorize ('Ver servicios');
        $servicio = Servicio::with(['users', 'membresias'])->get();
        return new ServicioCollection($servicio);
    }
    public function show($id){
        $this ->authorize('Ver servicios');
        $servicio = Servicio::find($id);
        if ($servicio) {
            return new ServicioResource($servicio);
        } else {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
    }
    public function store(StoreMembresiasRequest $request){
        $this->authorize('Crear servicios');
        $servicio= Servicio::create ($request->validate());

        return (new ServicioResource($servicio))
        ->respone()
        ->setStatusCode(201);
    }
    public function update(StoreMembresiasRequest $request, $id){
        $this->authorize('Actualizar servicios');
        $servicio = Servicio::find($id);
        if ($servicio) {                
            $servicio::update($request->validate());
            return new ServicioResource($servicio);
        } else {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
    }
    
    Public function destroy($id){
        $this->authorize('Eliminar servicios');
        $servicio = Servicio::find($id);
        if ($servicio) {
            $servicio->delete();
            return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
    }
}
