<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:technician');
    }

    public function getDashboardData()
    {
        $technician = Auth::guard('technician')->user();
        $technicianId = $technician->technician_id;

        // Get current date and 30 days ago
        $now = Carbon::now();
        $thirtyDaysAgo = $now->subDays(30);

        // Get summary counts
        $counts = [
            'logged' => DB::table('incidents')
                ->where('technician_id', $technicianId)
                ->where('status', 'Logged')
                ->count(),
            'in_progress' => DB::table('incidents')
                ->where('technician_id', $technicianId)
                ->where('status', 'in-progress')
                ->count(),
            'escalated' => DB::table('incidents')
                ->where('technician_id', $technicianId)
                ->where('status', 'Escalate')
                ->count(),
            'completed' => DB::table('incidents')
                ->where('technician_id', $technicianId)
                ->where('status', 'Completed')
                ->count()
        ];

        // Get tickets by status for pie chart
        $ticketsByStatus = DB::table('incidents')
            ->where('technician_id', $technicianId)
            ->select(DB::raw('COALESCE(status, "Unknown") as status'), DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Calculate average resolution time
        $avgResolutionTime = DB::table('incidents')
            ->where('technician_id', $technicianId)
            ->where('status', 'Completed')
            ->whereNotNull('completed_at')
            ->select(DB::raw('ROUND(COALESCE(AVG(TIMESTAMPDIFF(HOUR, date, completed_at)), 0), 1) as avg_hours'))
            ->first();

        // Get tickets by priority for bar chart
        $ticketsByPriority = DB::table('incidents')
            ->where('technician_id', $technicianId)
            ->select(DB::raw('COALESCE(priority, "Unknown") as priority'), DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->get();

        // Get recent tickets with proper date formatting
        $recentTickets = DB::table('incidents')
            ->where('technician_id', $technicianId)
            ->select('*', DB::raw('DATE_FORMAT(date, "%Y-%m-%d %H:%i:%s") as formatted_date'))
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function($ticket) {
                $ticket->formatted_date = Carbon::parse($ticket->formatted_date);
                return $ticket;
            });

        return view('technician.analytics', compact(
            'counts',
            'ticketsByStatus',
            'avgResolutionTime',
            'ticketsByPriority',
            'recentTickets'
        ));
    }
}