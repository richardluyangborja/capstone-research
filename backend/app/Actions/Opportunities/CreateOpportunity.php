<?php

namespace App\Actions\Opportunities;

use App\Enums\OpportunityStage;
use App\Models\Opportunity;

class CreateOpportunity
{
    public function handle(array $data): Opportunity
    {
        return Opportunity::create([
            ...$data,
            'stage' => OpportunityStage::INITIAL_CONTACT,
        ]);
    }
}
