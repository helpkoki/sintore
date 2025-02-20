<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Technician;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //logged_ticket
    public function logged()
    {
        // Get the currently authenticated technician
        $technician = Auth::guard('technician')->user();

        // Get all tickets assigned to this technician
        $tickets = DB::table('incidents')
            ->join('users', 'incidents.user_id', '=', 'users.user_id')
            ->join('technician', 'incidents.technician_id', '=', 'technician.technician_id')
            ->join('company', 'incidents.company_id', '=', 'company.company_id')
            ->where('incidents.technician_id', $technician->technician_id)
            ->where('incidents.status', 'Logged')
            ->select(
                'incidents.*',
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
                'users.email as user_email',
                'users.mobile as user_mobile',
                'technician.first_name as tech_first_name',
                'technician.last_name as tech_last_name',
                'company.c_name as company_name'
            )
            ->get();
        
        // Get all technicians for the escalation modal
    $technicians = DB::table('technician')->select('technician_id', 'first_name', 'last_name')->get();

    return view('technician.logged', compact('tickets', 'technicians'));
    }

    //in_progress ticket
    public function inProgress()
    {
        // Get the currently authenticated technician
        $technician = Auth::guard('technician')->user();

        // Get all tickets assigned to this technician
        $tickets = DB::table('incidents')
            ->join('users', 'incidents.user_id', '=', 'users.user_id')
            ->join('technician', 'incidents.technician_id', '=', 'technician.technician_id')
            ->join('company', 'incidents.company_id', '=', 'company.company_id')
            ->where('incidents.technician_id', $technician->technician_id)
            ->where('incidents.status', 'in-progress')
            ->select(
                'incidents.*',
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
                'users.email as user_email',
                'users.mobile as user_mobile',
                'technician.first_name as tech_first_name',
                'technician.last_name as tech_last_name',
                'company.c_name as company_name'
            )
            ->get();
        
        // Get all technicians for the escalation modal
        $technicians = DB::table('technician')->select('technician_id', 'first_name', 'last_name')->get();

        return view('technician.in_progress', compact('tickets', 'technicians'));
    }

    //escalated ticket
    public function escalated()
    {
        // Get the currently authenticated technician
        $technician = Auth::guard('technician')->user();
        
        // Get all tickets assigned to this technician
        $tickets = DB::table('incidents')
            ->join('users', 'incidents.user_id', '=', 'users.user_id')
            ->join('technician', 'incidents.technician_id', '=', 'technician.technician_id')
            ->join('company', 'incidents.company_id', '=', 'company.company_id')
            ->where('incidents.technician_id', $technician->technician_id)
            ->where('incidents.status', 'Escalate')
            ->select(
                'incidents.*',
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
                'users.email as user_email',
                'users.mobile as user_mobile',
                'technician.first_name as tech_first_name',
                'technician.last_name as tech_last_name',
                'company.c_name as company_name'
            )
            ->get();
        
        return view('technician.escalated', compact('tickets'));
    }

        public function escalateTicket(Request $request, $id)
    {
        $validated = $request->validate([
            'technician_id' => 'required|exists:technician,technician_id',
            'reason' => 'required|string|max:255',
        ]);

        $ticket = Incident::findOrFail($id);
        $ticket->technician_id = $validated['technician_id'];
        $ticket->status = 'Escalate';
        $ticket->escalation_reason = $validated['reason'];
        $ticket->save();

        return response()->json(['success' => true, 'message' => 'Ticket escalated successfully']);
    }



    //completed ticket
   public function completed()
{
    // Ensure the technician is authenticated
    $technician = Auth::guard('technician')->user();

    if (!$technician) {
        // Handle the case where the technician is not authenticated
        dd('Technician is not authenticated.');
    }

    // Get the technician_id of the authenticated technician
    $technicianId = $technician->technician_id;

    // Debug: Check the technicianId
    // dd($technicianId);

        // Fetch tickets with "Completed" status
        $tickets = DB::table('incidents')
            ->leftJoin('users', 'incidents.user_id', '=', 'users.user_id') // Join with users
            ->leftJoin('technician', 'incidents.technician_id', '=', 'technician.technician_id')
            ->where('incidents.technician_id', $technicianId)
            ->whereRaw('LOWER(incidents.status) = ?', ['completed']) // Case-insensitive matching
            ->orderBy('incidents.date', 'desc')
            ->select(
                'incidents.*',
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
                'users.mobile as user_mobile',
                'users.email as user_email',
                'incidents.priority as priority',
                'technician.first_name as tech_first_name',
                'technician.last_name as tech_last_name'
            )
            ->get();

        // Debug: Check the results
        //dd($tickets);

        // Pass the tickets to the view
        return view('technician.completed', compact('tickets'));
}



    public function getTicketDetails($ticketId)
    {
        $ticket = DB::table('incidents')
            ->join('users', 'incidents.user_id', '=', 'users.user_id')
            ->join('company', 'users.company_id', '=', 'company.company_id')  // Changed to join through users table
            ->where('incidents.tick_id', $ticketId)
            ->select(
                'incidents.tick_id',
                'incidents.date',
                'incidents.os',
                'incidents.description',
                'incidents.department',
                'incidents.status',
                'incidents.priority',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.mobile',
                'company.c_name as company_name'  // Aliased for consistency
            )
            ->first();

        if (!$ticket) {
            \Log::error("Ticket not found: $ticketId");
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        // Log the response for debugging
        \Log::info('Ticket details response:', ['ticket' => $ticket]);

        return response()->json($ticket);
    }

    public function updateStatus(Request $request, $ticketId)
    {
        try {
            DB::table('incidents')
                ->where('tick_id', $ticketId)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status'
            ], 500);
        }
    }

    public function edit($id)
    {
        $technician = Technician::findOrFail($id); // Retrieve technician by ID

        return view('technician.update', compact('technician')); // Pass it to the view
    }
    public function update(Request $request, $id)
    {
        $technician = Technician::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50|unique:technician,email,' . $id . ',technician_id',
            'mobile' => 'nullable|string|max:20',
            'level' => 'nullable|integer',
        ]);

        // Remove empty fields to avoid overriding existing values
        $filteredData = array_filter($validatedData, fn($value) => !is_null($value));

        $technician->update($filteredData);

        return redirect()->route('technician.edit', $id)->with('success', 'Technician updated successfully');
    }

}