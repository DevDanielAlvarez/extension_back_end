<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Patient\AttachResponsibleRequest;
use App\Http\Resources\Api\V1\PatientResource;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientResponsibleController extends Controller
{
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
}
