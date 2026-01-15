<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\ResponsibleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Responsible\CreateResponsibleRequest;
use App\Http\Resources\Api\V1\ResponsibleResource;
use App\Models\Responsible;
use App\Services\ResponsibleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    public function index()
    {
        return ResponsibleResource::collection(Responsible::paginate(10));
    }

    public function store(CreateResponsibleRequest $request): JsonResponse
    {
        // get validated data
        $data = $request->validated();
        //create a dto to create a responsible
        $responsibleDTO = ResponsibleDTO::fromArray($data);
        // create a responsible using responsible service
        $responsibleService = ResponsibleService::create($responsibleDTO);
        // return response with responsible and a message
        return response()->json([
            'message' => 'Responsible created successfully',
            'data' => new ResponsibleResource($responsibleService->getRecord())
        ], 201);
    }
}
