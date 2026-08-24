<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReminderRequest;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $reminders = Reminder::query()
            ->with([
                'company',
                'relatedTo',
            ])
            ->latest()
            ->paginate(15);

        return ReminderResource::collection($reminders);
    }

    public function store(StoreReminderRequest $request)
    {
        $reminder = Reminder::create($request->validated());

        $reminder->load([
            'company',
            'relatedTo',
        ]);

        return new ReminderResource($reminder);
    }

    public function show(Reminder $reminder)
    {
        $reminder->load([
            'company',
            'relatedTo',
        ]);

        return new ReminderResource($reminder);
    }

    public function update(Reminder $reminder)
    {
        $reminder->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        $reminder->load([
            'company',
            'relatedTo',
        ]);

        return new ReminderResource($reminder);
    }
}
