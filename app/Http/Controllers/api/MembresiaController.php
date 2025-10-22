<?php

namespace App\Http\Controllers\api;
use App\Http\Resources\MembresiaResource; // Importar el recurso CategoriaResource 
use App\Http\Resources\MembresiaCollection; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Membresia;

class MembresiaController extends Controller
{
     public function index(){
        $membresias = Membresia::all();
        return new MembresiaCollection($membresias);

}
    public function show($id){
        $membresia = Membresia::find($id);
        if ($membresia) {
            return new MembresiaResource($membresia);
        } else {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }
    }
    public function destroy($id){
        $membresia = Membresia::find($id);
        if ($membresia) {
            $membresia->delete();
            return response()->json(['message' => 'Membresía eliminada correctamente'], 200);
        } else {
            return response()->json(['message' => 'Membresía no encontrada'], 404);
        }
    }
}
