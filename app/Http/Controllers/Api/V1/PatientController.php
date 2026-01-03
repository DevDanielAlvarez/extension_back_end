<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\PatientDto;
use App\Enums\DocumentTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Patient\StorePatientRequest;
use App\Http\Resources\Api\V1\PatientResource;
use App\Services\PatientService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PatientController extends Controller
{
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
}
