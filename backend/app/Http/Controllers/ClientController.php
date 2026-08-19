<?php

namespace App\Http\Controllers;

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
            'assignedTo',
        ]);

        return new ClientResource($client);
    }
}
