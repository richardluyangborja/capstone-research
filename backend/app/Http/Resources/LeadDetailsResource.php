<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'status' => $this->status->value,

            'source' => $this->source,

            'notes' => $this->notes,

            'created_at' => $this->created_at,

            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'industry' => $this->company->industry,
                'address' => $this->company->address,
                'phone' => $this->company->phone,
                'email' => $this->company->email,
                'website' => $this->company->website,
            ],

            'contacts' => $this->company->contacts->map(
                fn ($contact) => [
                    'id' => $contact->id,
                    'name' => "{$contact->first_name} {$contact->last_name}",
                    'title' => $contact->title,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'is_primary' => $contact->is_primary,
                ]
            ),

            'opportunities' => OpportunitySummaryResource::collection($this->opportunities),

            'sales_representative' => [
                'id' => $this->assignedTo->id,
                'name' => $this->assignedTo->name,
            ],
        ];
    }
}
