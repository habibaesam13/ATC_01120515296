<?php

namespace App\Http\Controllers\system;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\EventService;

class EventController extends Controller
{
    protected  $eventService;
    public function __construct(EventService $eventService){
        $this->eventService=$eventService;
    }
    public function create()
    {
        $categories=Category::all();
        return view("Admin.events.create",compact('categories'));
    }
    public function store(Request $request){
        // dd($request);
        $data=$request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'number_of_tickets' => 'required|numeric|min:1',
            'date' => 'required|date|after_or_equal:today',
            'venue' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',]
        );
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }
        
        $result = $this->eventService->store($data);
        return $result===1? redirect()->route('admin.dashboard')->with('success', "Event added successfully")
        : back()->with('error', "Event already exists");
    }

    public function show($id)
    {
        $event = $this->eventService->find($id);
        
        if ($event === -1) {
            return redirect()->route('admin.dashboard')->with('error', 'Event not found');
        }
    
        return view("Admin.events.show", compact('event'));
    }
    public function edit($id){
        $categories=Category::all();
        $event=$this->eventService->find($id);
        if($event) return view("Admin.events.edit",compact(["event","categories"]));
        return redirect()->route('admin.dashboard')->with('error', 'Event not found');
    }

    public function update(Request $request,$id){
        // dd($request);
        $data=$request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'number_of_tickets' => 'required|numeric|min:1',
            'date' => 'required|date|after_or_equal:today',
            'venue' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',]
        );
        $result=$this->eventService->update($data,$id);
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

}
