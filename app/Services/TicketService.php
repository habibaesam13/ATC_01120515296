<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;

class TicketService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}
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

    public function countUserTicketsForEvent($userId, $eventId): int
    {
        return Ticket::where('user_id', $userId)
                     ->where('event_id', $eventId)
                     ->where('status','booked')
                     ->count();
    }

    public function countRemainingTicketsForEvent($event): int
{
    $bookedTickets = Ticket::where('event_id', $event->id)
                           ->where('status', 'booked')
                        ->count();

    return $event->number_of_tickets - $bookedTickets;
}
public function bookTicket(Event $event, $userId)
{
    // Check if user already booked a ticket
    $alreadyBooked = $this->countUserTicketsForEvent($userId,$event->id);
    $ticket = Ticket::where('event_id', $event->id)
    ->where('status','available')
                    ->first();
    // if ($alreadyBooked) {
    //     return 'You already booked this event.';
    // }

    // Check if tickets are available
    $remaining = $this->countRemainingTicketsForEvent($event);
    if ($remaining <= 0) {
        return 'No tickets available.';
    }

    // Book the ticket
    $ticket->status = 'booked';
    $ticket->user_id=$userId;
    $ticket->save();

    return 'Ticket booked successfully.';
}

public function unbookTicket(Event $event, $userId)
{
    // Find booked ticket for user
    $ticket = Ticket::where('user_id', $userId)
        ->where('event_id', $event->id)
        ->where('status', 'booked')
        ->first();

    if (!$ticket) {
        return 'You have no booked ticket to cancel.';
    }

    // Unbook ticket
    $ticket->update(['status' => 'available',
'user_id'=>null]);
    return 'Ticket unbooked.';
}

public function unbookAllTickets(Event $event, $userId)
{
    // Unbook all tickets for this event for the user
    Ticket::where('user_id', $userId)
        ->where('event_id', $event->id)
        ->where('status', 'booked')
        ->update(['status' => 'available','user_id'=>null]);

    return 'All tickets unbooked.';
}
}
