<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\VentaResource; // Importar el recurso CategoriaResource
use App\Http\Resources\VentaCollection; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Venta;

class VentaController extends Controller
{
    public function index(){
        $ventas = Venta::all();
        return new VentaCollection($ventas);
    }
    public function show($id){
        $venta = Venta::find($id);
        if ($venta) {
            return new VentaResource($venta);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }
    }
    public function destroy($id){
        $venta = Venta::find($id);
        if ($venta) {
            $venta->delete();
            return response()->json(['message' => 'Venta eliminada correctamente'], 200);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }
    }
}
