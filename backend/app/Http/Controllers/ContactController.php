<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());

        return response()->json([
            'data' => [
                'id' => $contact->id,
                'name' => "{$contact->first_name} {$contact->last_name}",
                'title' => $contact->title,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'is_primary' => $contact->is_primary,
            ],
        ], 201);
    }

    public function update(Contact $contact): JsonResponse
    {
        Contact::where('company_id', $contact->company_id)
            ->update(['is_primary' => false]);

        $contact->update(['is_primary' => true]);

        return response()->json([
            'data' => [
                'id' => $contact->id,
                'name' => "{$contact->first_name} {$contact->last_name}",
                'title' => $contact->title,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'is_primary' => true,
            ],
        ]);
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json(null, 204);
    }
}
