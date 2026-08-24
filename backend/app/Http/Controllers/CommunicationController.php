<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunicationRequest;
use App\Http\Resources\CommunicationResource;
use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    public function index(Request $request)
    {
        $communications = Communication::query()
            ->with([
                'company',
                'contact',
                'user',
            ])
            ->latest()
            ->paginate(15);

        return CommunicationResource::collection($communications);
    }

    public function store(StoreCommunicationRequest $request)
    {
        $communication = Communication::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        $communication->load([
            'company',
            'contact',
            'lead',
            'client',
            'user',
        ]);

        return new CommunicationResource($communication);
    }

    public function show(Communication $communication)
    {
        $communication->load([
            'company',
            'lead',
            'client',
            'contact',
            'user',
        ]);

        return new CommunicationResource($communication);
    }
}
