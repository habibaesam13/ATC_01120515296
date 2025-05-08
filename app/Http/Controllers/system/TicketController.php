<?php

namespace App\Http\Controllers\system;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketService;

class TicketController extends Controller
{
    protected $ticketService;
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }
    public function showEventTickets($eventId)
    {
        $event = Event::find($eventId);
        if (!$event) {
            return redirect()->route("admin.dashboard")->with("error", "Event not Found");
        }

        $result = $this->ticketService->getEventTickets($eventId);

        if ($result === -1) {
            return view('tickets.eventTickets', ['event' => $event])->with('error', 'No tickets available for this event.');
        }

        return view('tickets.eventTickets', ['event' => $event, 'tickets' => $result]);
    }
}
