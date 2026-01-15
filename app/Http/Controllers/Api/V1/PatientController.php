<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\PatientDto;
use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Patient\StorePatientRequest;
use App\Http\Requests\Api\V1\Patient\UpdatePatientRequest;
use App\Http\Resources\Api\V1\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Throwable;

class PatientController extends Controller
{
    /**
     * Get all patients
     * 
     * Retrieves a paginated list of all patients.
     *
     * @return AnonymousResourceCollection Paginated collection of patients
     */
    #[OA\Get(
            path: '/api/v1/patients',
            summary: 'List all patients',
            description: 'Retrieves a paginated list of all patients',
            tags: ['Patients'],
            responses: [
                new OA\Response(response: 200, description: 'Success'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function index(): AnonymousResourceCollection
    {
        return PatientResource::collection(Patient::paginate(10));
    }

    /**
     * Show individual patient
     * 
     * Retrieves a specific patient by ID.
     *
     * @param string $id - Patient ID
     * @return PatientResource Patient data
     */
    #[OA\Get(
            path: '/api/v1/patients/{id}',
            summary: 'Get patient by ID',
            description: 'Retrieves a specific patient by ID',
            tags: ['Patients'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    description: 'Patient ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            responses: [
                new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(ref: '#/components/schemas/PatientResource')),
                new OA\Response(response: 404, description: 'Patient not found'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function show(string $id): PatientResource
    {
        //find user using id from request
        $patient = Patient::findOrFail($id);
        //return patient found
        return PatientResource::make($patient);
    }
    /**
     * Create new patient
     * 
     * Creates a new patient record with the provided information.
     *
     * @param StorePatientRequest $request - Required fields: [name, document_type, document_number, telephone]
     * @return JsonResponse Created patient data with confirmation message
     */
    #[OA\Post(
            path: '/api/v1/patients',
            summary: 'Create new patient',
            description: 'Creates a new patient record with provided information',
            tags: ['Patients'],
            requestBody: new OA\RequestBody(
                description: 'Data for creating new patient',
                required: true,
                content: new OA\JsonContent(ref: '#/components/schemas/PatientDto')
            ),
            responses: [
                new OA\Response(response: 201, description: 'Created', content: new OA\JsonContent(ref: '#/components/schemas/PatientResource')),
                new OA\Response(response: 422, description: 'Validation Error')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function store(StorePatientRequest $request): JsonResponse
    {
        //get validated data from request
        $validatedFields = $request->validated();
        //convert validated fields in a dto
        $patientDto = new PatientDto(
            name: $validatedFields['name'],
            document_type: DocumentTypeEnum::from($validatedFields['document_type']),
            document_number: $validatedFields['document_number'],
            birthday: Carbon::createFromFormat('Y-m-d', $validatedFields['birthday']),
            telephone: $validatedFields['telephone'],
            admission_date: now(),
            nursing_assessments: $validatedFields['nursing_assessments'],
            id: null
        );
        //use the service to create a patient
        $patient = PatientService::create($patientDto)->getRecord();
        //returns the patient created, status code and message
        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => PatientResource::make($patient),
        ], 201);
    }

    public function update(string $id, UpdatePatientRequest $request): JsonResponse
    {
        // Get validated fields from http request
        $validatedFields = $request->validated();
        // Find the patient to update
        $patient = PatientService::find($id);
        // Create a dto to update the patient
        $dto = new PatientDto(
            name: $validatedFields['name'],
            document_type: DocumentTypeEnum::from($validatedFields['document_type']),
            document_number: $validatedFields['document_number'],
            birthday: Carbon::createFromFormat('Y-m-d', $validatedFields['birthday']),
            telephone: $validatedFields['telephone'],
            nursing_assessments: $validatedFields['nursing_assessments'],
            admission_date: Carbon::createFromFormat('Y-m-d', $validatedFields['admission_date']),
            id: $id // Optional because the ID is provided via HTTP request parameter
        );
        // Update patient using the previously created DTO
        $patient->update($dto);
        //return the patient
        return response()->json([
            'message' => 'Record updated successfully',
            'data' => PatientResource::make($patient->getRecord())
        ]);
    }

    /**
     * Delete patient
     * 
     * Deletes a specific patient by ID.
     *
     * @param string $id - Patient ID
     * @return Response|JsonResponse No content on success or error message
     */
    #[OA\Delete(
            path: '/api/v1/patients/{id}',
            summary: 'Delete patient',
            description: 'Deletes a specific patient by ID',
            tags: ['Patients'],
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    description: 'Patient ID',
                    schema: new OA\Schema(type: 'string')
                )
            ],
            responses: [
                new OA\Response(response: 204, description: 'Patient deleted successfully'),
                new OA\Response(response: 404, description: 'Patient not found'),
                new OA\Response(response: 500, description: 'Server error'),
                new OA\Response(response: 401, description: 'Unauthenticated')
            ],
            security: [['bearerAuth' => []]]
        )]
    public function destroy(string $id): Response|JsonResponse
    {
        try {
            $patient = PatientService::find($id);
            $patient->delete();
            return response()->noContent();
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], status: 500);
        }
    }
}
