<?php

namespace App\Http\Requests;

use App\Enums\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => [
                'sometimes',
                'integer',
                'exists:companies,id',
            ],

            'assigned_to_id' => [
                'sometimes',
                'integer',
                'exists:users,id',
            ],

            'source' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'status' => [
                'sometimes',
                Rule::enum(LeadStatus::class),
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }
}
