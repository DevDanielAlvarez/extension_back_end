<?php

namespace App\Http\Requests\Api\V1\Patient;

use App\Enums\DocumentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'document_type' => [Rule::enum(DocumentTypeEnum::class), 'required'],
            'document_number' => ['required', 'string', 'max:255'],
            'birthday' => ['date'],
            'telephone' => ['required', 'string', 'max:50'],
            'nursing_assessments' => []
        ];
    }
}
