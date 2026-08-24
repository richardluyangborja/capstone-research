<?php

namespace App\Http\Controllers;

use App\Actions\Leads\CreateLead;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateLeadStatusRequest;
use App\Http\Resources\LeadDetailsResource;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\Reminder;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'opportunities.assignedTo',
            'assignedTo',
        ]);

        return new LeadDetailsResource($lead);
    }

    public function show(Lead $lead)
    {
        $lead->load([
            'company.contacts',
            'opportunities.assignedTo',
            'assignedTo',
            'statusHistories.user',
            'communications.company',
            'communications.contact',
            'communications.user',
            'reminders.company',
            'reminders.relatedTo',
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
            'statusHistories.user',
        ]);

        return new LeadResource($lead);
    }

    public function updateStatus(
        UpdateLeadStatusRequest $request,
        Lead $lead
    ) {
        $validated = $request->validated();

        $fromStatus = $lead->status->value;

        $lead->update([
            'status' => $validated['to_status'],
        ]);

        StatusHistory::create([
            'lead_id' => $lead->id,
            'user_id' => Auth::id(),
            'from_status' => $fromStatus,
            'to_status' => $validated['to_status'],
            'reason' => $validated['reason'] ?? null,
        ]);

        if ($validated['to_status'] === 'converted') {
            Reminder::where('related_to_type', 'lead')
                ->where('related_to_id', $lead->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'incomplete',
                    'is_completed' => false,
                    'completed_at' => null,
                ]);
        }

        $lead->load([
            'company.contacts',
            'opportunities.assignedTo',
            'assignedTo',
            'statusHistories.user',
            'communications.company',
            'communications.contact',
            'communications.user',
            'reminders.company',
            'reminders.relatedTo',
        ]);

        return new LeadDetailsResource($lead);
    }
}
