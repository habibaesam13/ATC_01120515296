<?php

namespace App\Services;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Hash;
use App\Services\EventService;
class UserService
{
    protected $eventService;
    /**
     * Create a new class instance.
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService=$eventService;
    }
    public function getAllUsers()
    {
        $users = User::with(['events', 'tickets'])->paginate(10);
        if (!$users){
            return -1;
        }
        return $users;
    }
    public function show($userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            return null; // Or handle the user not found case
        }
        
        // Retrieve and group the tickets by event
        $tickets = Ticket::where('user_id', $userId)
            ->with('event')  // Eager load the event
            ->get()
            ->groupBy('event_id');  // Group tickets by event_id

        return [
            'user' => $user,
            'tickets' => $tickets,
        ];
    }
    public function store($data){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    if ($user) return 1;
    }
    public function update($data, $userId)
{
    // Find the user to be updated
    $user = User::find($userId);

    // Check if the new email is different and already taken by another user
    if ($user->email !== $data['email']) {
        // Check if the email is already in use by another user
        $emailExists = User::where('email', $data['email'])->exists();

        if ($emailExists) {
            return 0;
        }
    }

    // Proceed with updating the user data
    $user->name = $data['name'];
    $user->email = $data['email']; 
    $user->password = Hash::make($data['password']);
    $user->save();

    return 1; 
}

public function destroy($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return -1; // User not found
    }

    // Check if the user has booked any tickets
    $tickets = Ticket::where('user_id', $userId)->get();

    if ($tickets->isNotEmpty()) {
        // Update the tickets: set user_id to null and status to 'available'
        foreach ($tickets as $ticket) {
            $ticket->user_id = null;
            $ticket->status = 'available';
            $ticket->save();
        }
    }

    // Delete the user
    $user->delete();

    return 1; // Successfully deleted
}

}
