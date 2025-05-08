<?php

namespace App\Http\Controllers\HomePage;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    protected $eventService;
    public function __construct(EventService $eventService){
        $this->eventService=$eventService;
    }
    public function index() {
        $groupedEvents = $this->eventService->getAllEvents();
    
        $bookedEventIds = Ticket::where('user_id', Auth::id())
            ->where('status', 'booked')
            ->pluck('event_id')
            ->toArray();
    
        return view('Main.main', [
            'groupedEvents' => $groupedEvents,
            'bookedEventIds' => $bookedEventIds,
        ]);
    }
    
}
