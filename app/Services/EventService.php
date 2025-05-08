<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class EventService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllEvents()
{
    // Retrieve events with their associated categories and tickets
    $events = Event::with(['category', 'tickets'])->get();
    
    // Check if events exist
    if ($events->isEmpty()) {
        return -1;
    }

    // Group events by category
    $groupedEvents = $events->groupBy('category.name');
    
    return $groupedEvents;
}

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $imagePath = null;

            if (isset($data['image'])) {
                // Save new image
                $imageName = time() . '_' . uniqid() . '.' . $data['image']->extension();
                $data['image']->move(public_path('event_images'), $imageName);
                $imagePath = $imageName;
            }

            // Create the event
            $event = Event::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'category_id' => $data['category_id'],
                'number_of_tickets' => $data['number_of_tickets'],
                'date' => $data['date'],
                'venue' => $data['venue'],
                'image' => $imagePath,
            ]);

            // Create tickets
            for ($i = 0; $i < $data['number_of_tickets']; $i++) {
                Ticket::create([
                    'event_id' => $event->id,
                    'status' => 'available',
                ]);
            }

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return -1;
        }
    }
    public function find($id)
    {
        return Event::find($id) ?? -1;
    }
    public function update($data, $event_id)
    {
        $imagePath = null;
        $event = $this->find($event_id);
        if ($event === -1) return -1; // Not found

        DB::beginTransaction();
        try {
            // Image update
            if (isset($data['image'])) {
                $oldImagePath = public_path('event_images/' . $event->image);
                if (!empty($event->image) && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                } else {
                    logger()->warning("Image not deleted. Path checked: $oldImagePath");
                }
                $imageName =  time() . '_' . uniqid() . '.' . $data['image']->extension();
                $data['image']->move(public_path('event_images'), $imageName);
                $imagePath = $imageName;
            }

            // Ticket adjustment logic
            $oldTicketCount = $event->number_of_tickets;
            $newTicketCount = $data['number_of_tickets'];

            if ($newTicketCount > $oldTicketCount) {
                // Add extra tickets
                $ticketsToAdd = $newTicketCount - $oldTicketCount;
                for ($i = 0; $i < $ticketsToAdd; $i++) {
                    Ticket::create([
                        'event_id' => $event->id,
                        'status' => 'available',
                    ]);
                }
            } elseif ($newTicketCount < $oldTicketCount) {
                // Remove available tickets only
                $ticketsToDelete = $oldTicketCount - $newTicketCount;
                $availableTickets = Ticket::where('event_id', $event->id)
                    ->where('status', 'available')
                    ->limit($ticketsToDelete)
                    ->get();

                // Ensure enough available tickets exist
                if ($availableTickets->count() < $ticketsToDelete) {
                    DB::rollBack();
                    return -2; // Not enough available tickets to delete
                }

                foreach ($availableTickets as $ticket) {
                    $ticket->delete();
                }
            }

            // Update event fields
            $event->name = $data['name'];
            $event->description = $data['description'];
            $event->price = $data['price'];
            $event->category_id = $data['category_id'];
            $event->number_of_tickets = $newTicketCount;
            $event->date = $data['date'];
            $event->venue = $data['venue'];
            $event->image = $imagePath;
            $event->save();
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return -1;
        }
    }
    public function destroy($eventId)
    {
        $event = Event::find($eventId);

        if (! $event) {
            return -1;
        }
        $event->delete();
        return 1;
    }
}
