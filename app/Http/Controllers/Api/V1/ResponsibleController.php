<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\ResponsibleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Responsible\CreateResponsibleRequest;
use App\Http\Requests\Api\V1\UpdateResponsibleRequest;
use App\Http\Resources\Api\V1\ResponsibleResource;
use App\Models\Responsible;
use App\Services\ResponsibleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ResponsibleController extends Controller
{
    /**
     * List all responsibles
     *
     * Retrieves a paginated list of all responsibles.
     *
     * @return AnonymousResourceCollection Paginated collection of responsibles
     */
    #[OA\Get(
            path: '/api/v1/responsibles',
            summary: 'List all responsibles',
            description: 'Retrieves a paginated list of all responsibles',
            tags: ['Responsibles'],
            responses: [
                new OA\Response(response: 200, description: 'Success'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function index(): AnonymousResourceCollection
    {
        return ResponsibleResource::collection(Responsible::paginate(10));
    }

    /**
     * Show individual responsible
     *
     * Retrieves a specific responsible by ID.
     *
     * @param string $id - Responsible ID
     * @return JsonResponse Responsible data
     */
    #[OA\Get(
            path: '/api/v1/responsibles/{id}',
            summary: 'Get responsible by ID',
            description: 'Retrieves a specific responsible by ID',
            tags: ['Responsibles'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    description: 'Responsible ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            responses: [
                new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/ResponsibleResource')),
                new OA\Response(response: 404, description: 'Responsible not found'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function show(string $id): JsonResponse
    {
        // find the responsible using responsible service
        $responsibleService = ResponsibleService::find($id);
        // return response with responsible
        return response()->json([
            'data' => new ResponsibleResource($responsibleService->getRecord())
        ]);
    }
    /**
     * Create new responsible
     *
     * Creates a new responsible record with the provided information.
     *
     * @param CreateResponsibleRequest $request
     * @return JsonResponse Created responsible data with confirmation message
     */
    #[OA\Post(
            path: '/api/v1/responsibles',
            summary: 'Create new responsible',
            description: 'Creates a new responsible record with provided information',
            tags: ['Responsibles'],
            requestBody: new OA\RequestBody(
                description: 'Data for creating new responsible',
                required: true,
                content: new OA\JsonContent(ref: '#/components/schemas/ResponsibleDTO')
            ),
            responses: [
                new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/ResponsibleResource')),
                new OA\Response(response: 422, description: 'Validation Error')
            ],
            security: [['bearerAuth' => []]]
        )]
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

    /**
     * Update responsible
     *
     * Updates a specific responsible by ID.
     *
     * @param string $id - Responsible ID
     * @param UpdateResponsibleRequest $request
     * @return JsonResponse Updated responsible data
     */
    #[OA\Put(
            path: '/api/v1/responsibles/{id}',
            summary: 'Update responsible',
            description: 'Updates a specific responsible by ID',
            tags: ['Responsibles'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    description: 'Responsible ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            requestBody: new OA\RequestBody(
                description: 'Data for updating responsible',
                required: true,
                content: new OA\JsonContent(ref: '#/components/schemas/ResponsibleDTO')
            ),
            responses: [
                new OA\Response(response: 200, description: 'Responsible updated successfully', content: new OA\JsonContent(ref: '#/components/schemas/ResponsibleResource')),
                new OA\Response(response: 404, description: 'Responsible not found'),
                new OA\Response(response: 422, description: 'Validation Error'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function update(string $id, UpdateResponsibleRequest $request): JsonResponse
    {
        // get validated data
        $data = $request->validated();
        // find the responsible using responsible service
        $responsibleService = ResponsibleService::find($id);
        //create a dto to update a responsible
        $responsibleDTO = ResponsibleDTO::fromArray($responsibleService->getRecord()->toArray());
        // clone dto with new data
        $responsibleDTO = $responsibleDTO->cloneWith($data);
        // update a responsible using responsible service
        $responsibleService->update($responsibleDTO);
        // return response with responsible and a message
        return response()->json([
            'message' => 'Responsible updated successfully',
            'data' => new ResponsibleResource($responsibleService->getRecord())
        ]);
    }

    /**
     * Delete responsible
     *
     * Deletes a specific responsible by ID.
     *
     * @param string $id - Responsible ID
     * @return Response No content on success
     */
    #[OA\Delete(
            path: '/api/v1/responsibles/{id}',
            summary: 'Delete responsible',
            description: 'Deletes a specific responsible by ID',
            tags: ['Responsibles'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    description: 'Responsible ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            responses: [
                new OA\Response(response: 204, description: 'Responsible deleted successfully'),
                new OA\Response(response: 404, description: 'Responsible not found'),
                new OA\Response(response: 500, description: 'Server error'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function destroy(string $id): Response
    {
        // find the responsible using responsible service
        $responsibleService = ResponsibleService::find($id);
        // delete a responsible using responsible service
        $responsibleService->delete();
        // return response with a message
        return response()->noContent();
    }

}
