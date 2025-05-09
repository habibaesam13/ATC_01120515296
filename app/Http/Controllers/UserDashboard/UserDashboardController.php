<?php

namespace App\Http\Controllers\UserDashboard;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{


    public function show(){
    $userId = Auth::user()->id;
    
    // Fetch the user and their tickets
    $user = Auth::user();
    $tickets = $user->tickets;  // Assuming there is a relationship between User and Ticket models

    // Return the view with the user and tickets data
    return view('User.dashboard', compact('user', 'tickets'));
}

}
