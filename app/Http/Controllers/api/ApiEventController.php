<?php

namespace App\Http\Controllers\api;

use App\Role;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\TicketService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiEventController extends Controller
{
     protected $eventService;
    protected $ticketService;

    public function __construct(EventService $eventService, TicketService $ticketService)
    {
        $this->eventService = $eventService;
        $this->ticketService = $ticketService;
    }

    public function create()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'number_of_tickets' => 'required|numeric|min:1',
            'date' => 'required|date|after_or_equal:today',
            'venue' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile(key: 'image')) {
            $data['image'] = $request->file('image');
        }

        $result = $this->eventService->store($data);

        if ($result === 1) {
            return response()->json(['message' => 'Event added successfully.'], 201);
        }

        return response()->json(['error' => 'Event already exists.'], 409);
    }

    public function show($id)
    {
        $event = $this->eventService->find($id);

        if ($event === -1) {
            return response()->json(['error' => 'Event not found.'], 404);
        }

        $user = Auth::user();
        $availableTickets = $this->ticketService->countRemainingTicketsForEvent($event);
        $data = ['event' => $event, 'available_tickets' => $availableTickets];

        if ($user->role === Role::USER) {
            $data['user_ticket_count'] = $this->ticketService->countUserTicketsForEvent($user->id, $event->id);
        }

        return response()->json($data);
    }

    public function edit($id)
    {
        $categories = Category::all();
        $event = $this->eventService->find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found.'], 404);
        }

        return response()->json(['event' => $event, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'number_of_tickets' => 'required|numeric|min:1',
            'date' => 'required|date|after_or_equal:today',
            'venue' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $result = $this->eventService->update($data, $id);

        if ($result === 1) {
            return response()->json(['message' => 'Event updated successfully.']);
        } elseif ($result === -2) {
            return response()->json(['error' => 'No available tickets exist.'], 400);
        } else {
            return response()->json(['error' => 'Event not found.'], 404);
        }
    }

    public function destroy($id)
    {
        $result = $this->eventService->destroy($id);

        if ($result === 1) {
            return response()->json(['message' => 'Event deleted successfully.']);
        }

        return response()->json(['error' => 'Event not found.'], 404);
    }

}
