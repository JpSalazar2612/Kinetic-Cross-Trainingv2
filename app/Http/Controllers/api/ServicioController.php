<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\ServicioResource; // Importar el recurso CategoriaResource
use App\Http\Resources\ServicioCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Servicio;

class ServicioController extends Controller
{
    public function index(){
        $servicios = Servicio::all();
        return new ServicioCollection($servicios);
    }
    public function show($id){
        $servicio = Servicio::find($id);
        if ($servicio) {
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
