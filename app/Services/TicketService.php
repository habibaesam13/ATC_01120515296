<?php

namespace App\Services;
use App\Models\Ticket;
class TicketService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        
    }
    public function index()
    {
        // Eager load the event relation and group tickets by event_id
        $tickets = Ticket::with('event')->get();

        // Group tickets by event_id
        $groupedTickets = $tickets->groupBy('event_id');

        return $groupedTickets;
    }
    public function getEventTickets($eventId)
{
    // Retrieve tickets for the specified event with eager loading for event data
    $tickets = Ticket::with('event')->where('event_id', $eventId)->get();
    
    if ($tickets->isEmpty()) {
        return -1; // No tickets found for the event
    }

    // Return the collection of tickets
    return $tickets;
}

}
