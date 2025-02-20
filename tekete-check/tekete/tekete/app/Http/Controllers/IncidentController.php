<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Technician;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    // Get all incidents
    public function getAllIncidents()
    {
        $incidents = Incident::with(['user', 'technician', 'company'])->get();
        return response()->json($incidents);
    }

    // Get incident by ID
    public function getIncidentById($id)
    {
        $incident = Incident::with(['user', 'technician', 'company'])->find($id);

        if (!$incident) {
            return response()->json(['message' => 'Incident not found'], 404);
        }

        return response()->json($incident);
    }

    // Get logged tickets for a technician
    public function getLoggedTickets($technicianId)
    {
        $tickets = Incident::with(['user', 'technician', 'company'])
            ->where('status', 'logged')
            ->where('technician_id', $technicianId)
            ->get();

        return response()->json($tickets);
    }

    // Get escalated tickets for a technician
    public function getEscalatedTickets($technicianId)
    {
        $tickets = Incident::with(['user', 'technician', 'company'])
            ->where('status', 'Escalate')
            ->where('technician_id', $technicianId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($tickets);
    }

    // Get completed tickets for a technician
    public function getCompletedTickets($technicianId)
    {
        $tickets = Incident::with(['user', 'technician', 'company'])
            ->where('status', 'Completed')
            ->where('technician_id', $technicianId)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($tickets);
    }

    // Get in-progress tickets for a technician
    public function getInProgressTickets($technicianId)
    {
        $tickets = Incident::with(['user', 'technician', 'company'])
            ->where('status', 'In-Progress')
            ->where('technician_id', $technicianId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($tickets);
    }

    // Get ticket details by ticket ID
    public function getTicketDetails($ticketId)
    {
        $ticket = Incident::with(['user', 'technician', 'company'])->find($ticketId);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->full_name = $ticket->user->first_name . ' ' . $ticket->user->last_name;

        return response()->json($ticket);
    }

    public function index()
    {
        // Fetch all incidents and available technicians
        $incidents = Incident::whereNull('technician_id')->get();
        $technicians = Technician::all();

        return view('admin.incidents', compact('incidents', 'technicians'));
    }

    public function assignTechnician(Request $request, $tick_id)
    {
        // Validate request
        $request->validate([
            'technician_id' => 'required|exists:technician,technician_id',
        ]);

        // Find the incident and update the technician assignment
        $incident = Incident::findOrFail($tick_id);
        $incident->technician_id = $request->technician_id;
        $incident->status = 'LOGGED'; // Optional: Update status
        $incident->save();

        return redirect()->back()->with('success', 'Technician assigned successfully!');
    }
}