<?php

namespace App\Http\Controllers;

use App\Actions\Opportunities\WinOpportunity;
use App\Http\Resources\WinOpportunityResource;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class WinOpportunityController extends Controller
{
    public function win(Request $request, Opportunity $opportunity, WinOpportunity $winOpportunity)
    {
        $result = $winOpportunity->handle($opportunity);

        return new WinOpportunityResource($result);
    }
}
