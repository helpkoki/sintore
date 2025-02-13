@extends('layouts.service_provider')

@section('title', 'Technician Dashboard - Tekete Management System')

@push('styles')
    <link href="{{ asset('css/serviceProvider.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-dark">
                <i class="bi bi-grid me-2"></i>Dashboard Overview
            </h2>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="row g-4 mb-4">
        <!-- Logged Tickets Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded p-3 bg-primary bg-opacity-10">
                                <i class="bi bi-bookmark text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Logged</h5>
                            <h3 class="mb-0 text-primary">{{ $counts['logged'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress Tickets Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded p-3 bg-warning bg-opacity-10">
                                <i class="bi bi-hourglass-split text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">In Progress</h5>
                            <h3 class="mb-0 text-warning">{{ $counts['in_progress'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Escalated Tickets Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded p-3 bg-danger bg-opacity-10">
                                <i class="bi bi-arrow-up-circle text-danger fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Escalated</h5>
                            <h3 class="mb-0 text-danger">{{ $counts['escalated'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Tickets Card -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded p-3 bg-success bg-opacity-10">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Completed</h5>
                            <h3 class="mb-0 text-success">{{ $counts['completed'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Total Tickets by Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="ticketsByStatusChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Average Resolution Time</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <h2 class="display-4">{{ $avgResolutionTime->avg_hours ?? '0' }}</h2>
                        <p class="text-muted">hours</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tickets by Priority</h5>
                </div>
                <div class="card-body">
                    <canvas id="ticketsByPriorityChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->tick_id }}</td>
                                <td>
                                    <span class="badge bg-{{ $ticket->status === 'Logged' ? 'primary' : 
                                        ($ticket->status === 'in-progress' ? 'warning' : 
                                        ($ticket->status === 'Escalate' ? 'danger' : 'success')) }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td>{{ $ticket->priority }}</td>
                                <td>{{ $ticket->formatted_date->diffForHumans() }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">View Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No recent activity</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Tickets by Status Chart
    var ticketsByStatusData = @json($ticketsByStatus ?? []);
    new Chart(document.getElementById("ticketsByStatusChart"), {
        type: 'pie',
        data: {
            labels: ticketsByStatusData.map(item => item.status),
            datasets: [{
                data: ticketsByStatusData.map(item => item.count),
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336', '#2196F3']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Tickets by Priority Chart
    var ticketsByPriorityData = @json($ticketsByPriority ?? []);
    new Chart(document.getElementById("ticketsByPriorityChart"), {
        type: 'bar',
        data: {
            labels: ticketsByPriorityData.map(item => item.priority),
            datasets: [{
                data: ticketsByPriorityData.map(item => item.count),
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FFC300']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
@endsection