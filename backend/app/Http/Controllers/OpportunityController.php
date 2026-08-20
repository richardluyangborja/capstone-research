<?php

namespace App\Http\Controllers;

use App\Actions\Opportunities\CreateOpportunity;
use App\Http\Requests\StoreOpportunityRequest;
use App\Http\Requests\UpdateOpportunityRequest;
use App\Http\Resources\OpportunityDetailsResource;
use App\Http\Resources\OpportunityResource;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $opportunities = Opportunity::query()
            ->with([
                'company',
                'assignedTo',
            ])
            ->latest()
            ->paginate(15);

        return OpportunityResource::collection($opportunities);
    }

    public function store(
        StoreOpportunityRequest $request,
        CreateOpportunity $createOpportunity
    ) {
        $opportunity = $createOpportunity->handle(
            $request->validated()
        );

        $opportunity->load([
            'company.contacts',
            'lead.company',
            'assignedTo',
        ]);

        return new OpportunityDetailsResource($opportunity);
    }

    public function show(Opportunity $opportunity)
    {
        $opportunity->load([
            'company.contacts',
            'lead.company',
            'assignedTo',
        ]);

        return new OpportunityDetailsResource($opportunity);
    }

    public function update(
        UpdateOpportunityRequest $request,
        Opportunity $opportunity
    ) {
        $opportunity->update($request->validated());

        $opportunity->load([
            'company.contacts',
            'lead.company',
            'assignedTo',
        ]);

        return new OpportunityDetailsResource($opportunity);
    }
}
