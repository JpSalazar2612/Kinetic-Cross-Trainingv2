<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Importación
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
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
}
