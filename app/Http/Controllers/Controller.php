<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;
#[OA\Info(
    version: "1.0.0",
    title: "Extension Api",
    description: "Documentation of extension api"
)]
#[OA\Server(url: 'http://localhost:8000', description: 'Local Server')]
abstract class Controller
{
    //
}
