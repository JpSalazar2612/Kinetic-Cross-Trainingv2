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
    public function index()
    {
        $this->authorize('Ver servicios');
        
        $servicios = Servicio::with(['membresia'])->paginate(10); 
        
        return new ServicioCollection($servicios);
    }

    /**
     * Muestra un servicio específico.
     * Usa Route Model Binding.
     */
    public function show(Servicio $servicio)
    {
        return new ServicioResource($servicio);
    }

    /**
     * Crea un nuevo servicio.
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
     * Actualiza un servicio existente.
     * Usa Route Model Binding.
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
     * Elimina un servicio.
     * Usa Route Model Binding.
     */
    public function destroy(Servicio $servicio)
    {
        $this->authorize('Eliminar servicios');
        
        $servicio->delete();
        
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
