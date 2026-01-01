<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Extension API",
    description: "Documentation of extension API"
)]
#[OA\Server(url: 'http://localhost:8000', description: 'Local Server')]
#[OA\SecurityScheme(
    type: 'http',
    description: 'Bearer token authentication',
    name: 'Authorization',
    in: 'header',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    securityScheme: 'bearerAuth'
)]
abstract class Controller
{
    //
}
