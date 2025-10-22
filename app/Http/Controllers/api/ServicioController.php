<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ServicioResource; // Importar el recurso CategoriaResource
use App\Http\Resources\ServicioCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Servicio;

use App\Http\Requests\StoreServiciosRequest;
use App\Http\Requests\UpdateServiciosRequest;   

class ServicioController extends Controller
{
    public function index(){
        $servicio = Servicio::all();
        return new ServicioCollection($servicio);
    }
    public function show($id){
        $servicio = Servicio::find($id);
        if ($servicio) {
            return new ServicioResource($servicio);
        } else {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
    }
    public function store(StoreMembresiasRequest $request){
        $servicio= Servicio::create ($request->validate());

        return (new ServicioResource($servicio))
        ->respone()
        ->setStatusCode(201);
    }
    public function update(StoreMembresiasRequest $request, $id){
        $servicio = Servicio::find($id);
        if ($servicio) {                
            $servicio::update($request->validate());
            return new ServicioResource($servicio);
        } else {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
    }
    
    Public function destroy($id){
        $servicio = Servicio::find($id);
        if ($servicio) {
            $servicio->delete();
            return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
    }
}
