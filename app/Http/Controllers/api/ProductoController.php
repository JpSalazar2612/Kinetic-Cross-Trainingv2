<?php

namespace App\Http\Controllers\api;
use App\Http\Resources\ProductoResource; // Importar el recurso CategoriaResource
use App\Http\Resources\ProductoCollection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index(){
        $productos = Producto::all();
        return new ProductoCollection($productos);
    }
    public function show($id){
        $producto = Producto::find($id);
        if ($producto) {
            return new ProductoResource($producto);
        } else {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    }
    public function destroy($id){
        $producto = Producto::find($id);
        if ($producto) {
            $producto->delete();
            return response()->json(['message' => 'Producto eliminado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    }
}
