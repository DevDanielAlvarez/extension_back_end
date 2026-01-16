<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Patient\AttachResponsibleRequest;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientResponsibleController extends Controller
{
    public function store(string $patientId, AttachResponsibleRequest $request)
    {
        // get validated data from http request
        $data = $request->validated();
        // find patient using id from url parameter
        $patient = PatientService::find($patientId);
        // attach responsible to patient
        $patient->getRecord()->responsibles()->attach($data['responsible_id']);
    }
}
