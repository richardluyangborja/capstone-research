<?php

namespace App\Http\Controllers;

use App\Actions\Opportunities\WinOpportunity;
use App\Http\Requests\WinOpportunityRequest;
use App\Http\Resources\WinOpportunityResource;
use App\Models\Opportunity;

class WinOpportunityController extends Controller
{
    public function win(WinOpportunityRequest $request, Opportunity $opportunity, WinOpportunity $winOpportunity)
    {
        $result = $winOpportunity->handle($opportunity, $request->validated()['reason'] ?? null);

        return new WinOpportunityResource($result);
    }
}
