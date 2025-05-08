<?php

namespace App\Http\Controllers\system;

use App\Role;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\TicketService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    protected  $eventService;
    protected $ticketService;
    public function __construct(EventService $eventService, TicketService $ticketService)
    {
        $this->eventService = $eventService;
        $this->ticketService = $ticketService;
    }
    public function create()
    {
        $categories = Category::all();
        return view("Admin.events.create", compact('categories'));
    }
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'number_of_tickets' => 'required|numeric|min:1',
                'date' => 'required|date|after_or_equal:today',
                'venue' => 'required|string',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]
        );
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $result = $this->eventService->store($data);
        return $result === 1 ? redirect()->route('admin.dashboard')->with('success', "Event added successfully")
            : back()->with('error', "Event already exists");
    }

    public function show($id)
{
    $event = $this->eventService->find($id);

    if ($event === -1) {
        $redirectRoute = Auth::user()->role === Role::USER ? 'home page' : 'admin.dashboard';
        return redirect()->route($redirectRoute)->with('error', 'Event not found');
    }

    $user = Auth::user();
    $availableTickets = $this->ticketService->countRemainingTicketsForEvent($event);
    if ($user->role === Role::USER) {
        $userTicketCount = $this->ticketService->countUserTicketsForEvent($user->id, $event->id);
        return view('User.eventShow', compact('event', 'userTicketCount', 'availableTickets'));
    }

    return view("Admin.events.show", compact('event', 'availableTickets'));
}

    public function edit($id)
    {
        $categories = Category::all();
        $event = $this->eventService->find($id);
        if ($event) return view("Admin.events.edit", compact(["event", "categories"]));
        return redirect()->route('admin.dashboard')->with('error', 'Event not found');
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $data = $request->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'number_of_tickets' => 'required|numeric|min:1',
                'date' => 'required|date|after_or_equal:today',
                'venue' => 'required|string',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]
        );
        $result = $this->eventService->update($data, $id);
        if ($result === 1) {
            return redirect()->route('admin.dashboard')->with('success', "Event updated successfully");
        } elseif ($result === -2) {
            return back()->with('error', "No available tickets exist");
        } else {
            return back()->with('error', "Event not found");
        }
    }
    public function destroy($id)
    {
        $result = $this->eventService->destroy($id);

        return $result === 1
            ? redirect()->route('admin.dashboard')->with('success', "Event deleted successfully")
            : back()->with('error', "Event not found");
    }

    //booking
    public function bookTicket(Event $event)
    {
        $user = Auth::user();
        $result = $this->ticketService->bookTicket($event, $user->id);
        $eventName=$event->name;
        if ($result === 'Ticket booked successfully.') {
            return view("Main.bookingSuccess",compact('eventName'));
        }

        return back()->with('error', $result);
    }

    public function unbookTicket(Event $event)
    {
        $user = Auth::user();
        $result = $this->ticketService->unbookTicket($event, $user->id);

        if ($result === 'Ticket unbooked.') {
            return back()->with('success', $result);
        }

        return back()->with('error', $result);
    }

    public function unbookAllTickets(Event $event)
    {
        $user = Auth::user();
        $result = $this->ticketService->unbookAllTickets($event, $user->id);

        return back()->with('success', $result);
    }

}
