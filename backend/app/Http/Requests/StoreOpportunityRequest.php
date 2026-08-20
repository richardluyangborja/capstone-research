<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;

class StoreOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],

            'lead_id' => [
                'nullable',
                'integer',
                'exists:leads,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $lead = Lead::find($value);

                        if ($lead && $lead->company_id !== (int) $this->input('company_id')) {
                            $fail('The selected lead does not belong to the selected company.');
                        }
                    }
                },
            ],

            'assigned_to_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'estimated_contract_value' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'expected_close_date' => [
                'nullable',
                'date',
            ],
        ];
    }
}
