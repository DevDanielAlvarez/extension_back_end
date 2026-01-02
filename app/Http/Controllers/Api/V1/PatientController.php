<?php

namespace App\Http\Controllers\Api\V1;

use App\Dto\PatientDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Patient\StorePatientRequest;
use App\Http\Resources\Api\V1\PatientResource;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * create new patient in database
     * @param StorePatientRequest $request
     * @return JsonResponse
     */
    public function store(StorePatientRequest $request): JsonResponse
    {
        //get validated data from request
        $validatedFields = $request->validated();
        //convert validated fields in a dto
        $patientDto = new PatientDto(
            name: $validatedFields['name'],
            document_type: $validatedFields['document_type'],
            document_number: $validatedFields['document_number'],
            birthday: $validatedFields['birthday'],
            telephone: $validatedFields['telephone'],
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
