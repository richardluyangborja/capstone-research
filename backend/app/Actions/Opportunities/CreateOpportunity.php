<?php

namespace App\Actions\Opportunities;

use App\Enums\OpportunityStage;
use App\Models\Lead;
use App\Models\Opportunity;

class CreateOpportunity
{
    public function handle(array $data): Opportunity
    {
        $data['assigned_to_id'] = $data['assigned_to_id']
            ?? Lead::find($data['lead_id'] ?? null)?->assigned_to_id
            ?? auth()->id();

        return Opportunity::create([
            ...$data,
            'stage' => OpportunityStage::INITIAL_CONTACT,
        ]);
    }
}
