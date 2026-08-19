<?php

namespace App\Http\Controllers;

use App\Actions\Leads\CreateLead;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Resources\LeadDetailsResource;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = Lead::query()
            ->with([
                'company.primaryContact',
                'assignedTo',
            ])
            ->latest()
            ->paginate(15);

        return LeadResource::collection($leads);
    }

    public function store(
        StoreLeadRequest $request,
        CreateLead $createLead
    ) {
        $lead = $createLead->handle(
            $request->validated()
        );

        $lead->load([
            'company.contacts',
            'assignedTo',
        ]);

        return new LeadDetailsResource($lead);
    }

    public function show(Lead $lead)
    {
        $lead->load([
            'company.contacts',
            'assignedTo',
        ]);

        return new LeadDetailsResource($lead);
    }

    public function update(
        UpdateLeadRequest $request,
        Lead $lead
    ) {
        $lead->update($request->validated());

        $lead->load([
            'company.contacts',
            'assignedTo',
        ]);

        return new LeadResource($lead);
    }
}
