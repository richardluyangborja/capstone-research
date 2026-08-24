<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientDetailsResource;
use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()
            ->with([
                'company.primaryContact',
                'assignedTo',
            ])
            ->latest()
            ->paginate(15);

        return ClientResource::collection($clients);
    }

    public function show(Client $client)
    {
        $client->load([
            'company.contacts',
            'company.opportunities.assignedTo',
            'assignedTo',
            'lead',
            'communications.company',
            'communications.contact',
            'communications.user',
            'reminders.company',
            'reminders.relatedTo',
            'surveys',
        ]);

        return new ClientDetailsResource($client);
    }
}
