<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a User model
use App\Models\Incidents; // Assuming you have an Incident model
use App\Services\DatabaseAPI;

use Illuminate\Support\Facades\Session;

class TrackTicketController extends Controller
{
    protected $DatabaseAPI;

    public function __construct(DatabaseAPI $DatabaseAPI){
        $this->DatabaseAPI  = $DatabaseAPI;
    
        // Initialize the session with a hardcoded email if not already set
        if (!Session::has('email')) {
            Session::put('email', 'mpsanekgotso@gmail.com');
        }
    }

    public function index()
    {
        $email = Session::get('email');
        
        // Fetch user details
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->with('alert', 'User  not found');
        }
        //get user_id from user object
        $userId = $user->user_id;

        // Fetch active and completed tickets using the model methods
        $activeTickets = $this->DatabaseAPI->getActiveTickets($userId);
        $completedTickets = $this->DatabaseAPI->getCompletedTickets($userId);

        // Return the view with user details and tickets
        return view('track_ticket', [
            'user' => $user,
            'activeTickets' => $activeTickets,
            'completedTickets' => $completedTickets,
        ]);
    }
}