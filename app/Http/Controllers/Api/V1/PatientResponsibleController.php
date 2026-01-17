<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Patient\AttachResponsibleRequest;
use App\Http\Resources\Api\V1\PatientResource;
use App\Http\Resources\Api\V1\ResponsibleResource;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class PatientResponsibleController extends Controller
{
    /**
     * Attach responsible to patient
     *
     * Attaches an existing responsible to a specific patient.
     *
     * @param string $patientId - Patient ID
     * @param AttachResponsibleRequest $request
     * @return JsonResponse Patient with attached responsibles
     */
    #[OA\Post(
            path: '/api/v1/patients/{patientId}/responsibles',
            summary: 'Attach responsible to patient',
            description: 'Attaches an existing responsible to a specific patient',
            tags: ['Patients'],
            parameters: [
                new OA\Parameter(
                    name: 'patientId',
                    in: 'path',
                    required: true,
                    description: 'Patient ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            requestBody: new OA\RequestBody(
                description: 'Responsible ID to attach',
                required: true,
                content: new OA\JsonContent(
                    required: ['responsible_id'],
                    properties: [
                        new OA\Property(property: 'responsible_id', type: 'string', example: '1')
                    ]
                )
            ),
            responses: [
                new OA\Response(response: 200, description: 'Responsible attached successfully', content: new OA\JsonContent(ref: '#/components/schemas/PatientResource')),
                new OA\Response(response: 404, description: 'Patient or Responsible not found'),
                new OA\Response(response: 422, description: 'Validation Error'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function store(string $patientId, AttachResponsibleRequest $request): JsonResponse
    {
        // get validated data from http request
        $data = $request->validated();
        // find patient using id from url parameter
        $patient = PatientService::find($patientId);
        // attach responsible to patient
        $patient->getRecord()->responsibles()->attach($data['responsible_id']);
        // return success response
        return response()->json([
            'message' => 'Responsible attached successfully.',
            'data' => PatientResource::make($patient->getRecord()->load('responsibles'))
        ], status: 200);
    }

    /**
     * List patient responsibles
     *
     * Retrieves all responsibles associated with a specific patient.
     *
     * @param string $patientId - Patient ID
     * @param Request $request
     * @return ResourceCollection Collection of responsibles
     */
    #[OA\Get(
            path: '/api/v1/patients/{patientId}/responsibles',
            summary: 'List patient responsibles',
            description: 'Retrieves all responsibles associated with a specific patient',
            tags: ['Patients'],
            parameters: [
                new OA\Parameter(
                    name: 'patientId',
                    in: 'path',
                    required: true,
                    description: 'Patient ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            responses: [
                new OA\Response(response: 200, description: 'Success'),
                new OA\Response(response: 404, description: 'Patient not found'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function index($patientId, Request $request): ResourceCollection
    {
        return
            ResponsibleResource::collection(
                PatientService::find($patientId)->getRecord()->responsibles
            );
    }

    /**
     * Detach responsible from patient
     *
     * Removes the association between a patient and a responsible.
     *
     * @param string $patientId - Patient ID
     * @param string $responsibleId - Responsible ID
     * @return Response No content on success
     */
    #[OA\Delete(
            path: '/api/v1/patients/{patientId}/responsibles/{responsibleId}',
            summary: 'Detach responsible from patient',
            description: 'Removes the association between a patient and a responsible',
            tags: ['Patients'],
            parameters: [
                new OA\Parameter(
                    name: 'patientId',
                    in: 'path',
                    required: true,
                    description: 'Patient ID',
                    schema: new OA\Schema(type: 'string')
                ),
                new OA\Parameter(
                    name: 'responsibleId',
                    in: 'path',
                    required: true,
                    description: 'Responsible ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            responses: [
                new OA\Response(response: 204, description: 'Responsible detached successfully'),
                new OA\Response(response: 404, description: 'Patient or Responsible not found'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function destroy($patientId, $responsibleId): Response
    {
        // find the patient using url parameter
        $patientService = PatientService::find($patientId);
        // detach the responsble from the patient
        $patientService->getRecord()->responsibles()->detach($responsibleId);
        return response()->noContent();
        // return no content response
    }
}
