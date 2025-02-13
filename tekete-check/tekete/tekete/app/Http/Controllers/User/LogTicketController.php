<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incident;
use App\Services\DatabaseAPI;
use Illuminate\Support\Facades\Session;

class LogTicketController extends Controller
{
    private $databaseAPI;

    public function __construct(DatabaseAPI $databaseAPI)
    {
        $this->databaseAPI = $databaseAPI;

        // Initialize the session with a hardcoded email if not already set
        if (!Session::has('email')) {
            Session::put('email', 'mpsanekgotso@gmail.com');
        }
    }

    public function create()
    {
        // Render the ticket logging form
        return view('log_ticket');
    }

    public function handleFormSubmission(Request $request)
{
    // Get user data from session
    $user_id = Session::get('user_id');
    $company_id = Session::get('company_id');

    // Validate the incoming request
    $validated = $request->validate([
        'os' => 'required|string',
        'department' => 'required|string',
        'description' => 'required|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'other_text' => 'nullable|string',
    ]);

    // Process the description field
    $description = $validated['description'] === "Other" && isset($validated['other_text'])
        ? $validated['other_text']
        : $validated['description'];

    // Handle file upload
    $attachment = null;
    if ($request->hasFile('attachment')) {
        $attachment = $this->uploadFile($request->file('attachment'));
    }

    // Create new incident record with user-specific data
    $isLogged = Incident::create([
        'date' => now()->format('Y-m-d'),
        'department' => $validated['department'],
        'description' => $description,
        'os' => $validated['os'],
        'path' => $attachment,
        'user_id' => $user_id,
        'company_id' => $company_id,
    ]);

    if ($isLogged) {
        return redirect()->back()->with('success', 'Ticket logged successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to log the ticket. Please try again.');
    }
}

    // Function to handle file upload
    private function uploadFile($file)
    {
        // Get the file extension
        $extension = $file->getClientOriginalExtension();

        // Generate a unique filename using the current timestamp and the file extension
        $filename = time() . '.' . $extension;

        // Store the file in the 'uploads' directory under 'public'
        $file->storeAs('uploads', $filename, 'public');
        return $filename;
    }
}