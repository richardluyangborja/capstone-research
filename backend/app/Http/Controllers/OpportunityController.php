<?php

namespace App\Http\Controllers;

use App\Actions\Opportunities\CreateOpportunity;
use App\Http\Requests\StoreOpportunityRequest;
use App\Http\Requests\UpdateOpportunityRequest;
use App\Http\Requests\UpdateOpportunityStageRequest;
use App\Http\Resources\OpportunityDetailsResource;
use App\Http\Resources\OpportunityResource;
use App\Models\Opportunity;
use App\Models\StageHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'stageHistories.user',
            'reminders.company',
            'reminders.relatedTo',
        ]);

        return new OpportunityDetailsResource($opportunity);
    }

    public function show(Opportunity $opportunity)
    {
        $opportunity->load([
            'company.contacts',
            'lead.company',
            'assignedTo',
            'stageHistories.user',
            'reminders.company',
            'reminders.relatedTo',
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
            'stageHistories.user',
            'reminders.company',
            'reminders.relatedTo',
        ]);

        return new OpportunityDetailsResource($opportunity);
    }

    public function updateStage(
        UpdateOpportunityStageRequest $request,
        Opportunity $opportunity
    ) {
        $validated = $request->validated();

        $fromStage = $opportunity->stage->value;

        $opportunity->update([
            'stage' => $validated['stage'],
        ]);

        StageHistory::create([
            'opportunity_id' => $opportunity->id,
            'user_id' => Auth::id(),
            'from_stage' => $fromStage,
            'to_stage' => $validated['stage'],
            'reason' => $validated['reason'] ?? null,
        ]);

        $opportunity->load([
            'company.contacts',
            'lead.company',
            'assignedTo',
            'stageHistories.user',
            'reminders.company',
            'reminders.relatedTo',
        ]);

        return new OpportunityDetailsResource($opportunity);
    }
}
