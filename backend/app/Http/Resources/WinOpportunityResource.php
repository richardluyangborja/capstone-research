<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WinOpportunityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Opportunity marked as won.',
            'data' => [
                'opportunity' => new OpportunityDetailsResource($this->resource['opportunity']),
                'client' => $this->resource['client'] ? new ClientResource($this->resource['client']) : null,
                'lead' => $this->resource['lead'] ? new LeadResource($this->resource['lead']) : null,
            ],
        ];
    }
}
