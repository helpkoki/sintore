@extends('layouts.service_provider')

@section('title', 'Technician Dashboard - Tekete Management System')

@push('styles')
    <link href="{{ asset('css/serviceProvider.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content">
    <h1>In-Progress Tickets</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ticket No</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Operating System</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Technician</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr class="clickable-row" data-ticket-id="{{ $ticket->tick_id }}">
                        <td>{{ $ticket->date }}/{{ $ticket->tick_id }}</td>
                        <td>{{ $ticket->user_first_name }} {{ $ticket->user_last_name }}</td>
                        <td>{{ $ticket->user_mobile }}</td>
                        <td>{{ $ticket->user_email }}</td>
                        <td>{{ $ticket->os }}</td>
                        <td>
                            <select class="form-control status-select" data-ticket-id="{{ $ticket->tick_id }}">
                                <option value="In-Progress" {{ $ticket->status == 'In-Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Escalate" {{ $ticket->status == 'Escalate' ? 'selected' : '' }}>Escalate</option>
                                <option value="Completed" {{ $ticket->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </td>
                        <td>{{ $ticket->priority }}</td>
                        <td>{{ $ticket->tech_first_name }} {{ $ticket->tech_last_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Include Ticket & Escalation Modals -->
@include('technician.ticket_modal')
@include('technician.escalation_modal')

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="{{ asset('js/serviceProvider.js') }}"></script>

@endpush
