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

    public function index(){
        $this->authorize ('Ver ventas');
        // CORRECCIÓN 1: Se elimina 'productos' de la carga eagerly, ya que no está definida en Venta.php
        $ventas = Venta::with(['user', 'membresia'])->get(); 
        return new VentaCollection($ventas);
    }
    
    public function show($id){
        $this ->authorize('Ver ventas');
        // CORRECCIÓN 1: Se elimina 'productos' de la carga eagerly
        $venta = Venta::with(['user', 'membresia'])->find($id); 
        
        if ($venta) {
            return new VentaResource($venta);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], Response::HTTP_NOT_FOUND); // Usamos la constante
        }
    }
    
    public function store(StoreVentasRequest $request){
        $this->authorize('Crear ventas');

        // *************** CORRECCIÓN CLAVE ***************
        // 1. Obtener la data validada del request
        $validatedData = $request->validated();
        
        // 2. Asignar el user_id del usuario autenticado antes de crear el registro
        $validatedData['user_id'] = $request->user()->id; 

        // 3. Crear la venta con la data completa (incluyendo user_id)
        $venta = Venta::create($validatedData);

        return (new VentaResource($venta))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED); // Usamos la constante 201
    }
    
    // Corregido: Usar UpdateVentasRequest en lugar de StoreVentasRequest
    public function update(UpdateVentasRequest $request, $id){
        $this->authorize('Actualizar ventas');
        $venta = Venta::find($id);
        
        if ($venta) {
            $venta->update($request->validated()); 
            return new VentaResource($venta);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id){
        $this->authorize('Eliminar ventas');
        $venta = Venta::find($id);
        
        if ($venta) {
            $venta->delete();
            return response()->json(['message' => 'Venta eliminada correctamente'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Venta no encontrada'], Response::HTTP_NOT_FOUND);
        }
    }
}