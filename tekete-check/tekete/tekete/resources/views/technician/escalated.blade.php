@extends('layouts.service_provider')

@section('title', 'Technician Dashboard - Tekete Management System')
@push('styles')
    <style>
        /* Table Styling */
        .table thead>tr>th {
            background-color: #d4d414;
            /* Yellow header */
            color: #666;
            /* Dark gray text */
            font-weight: bold;
        }

        .table th,
        .table td {
            text-align: center;
        }

        /* Dropdown Styling */
        select.form-control {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 1rem;
        }
    </style>
@endpush
@section('content')
<div class="content-wrapper" style="margin-left: 250px; padding: 20px;">
    <h1>Escalated Tickets</h1>

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
                                <option value="Escalate" {{ $ticket->status == 'Escalate' ? 'selected' : '' }}>Escalate
                                </option>
                                <option value="Completed" {{ $ticket->status == 'Completed' ? 'selected' : '' }}>Completed
                                </option>
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

@include('technician.ticket_modal')
@endsection
@push('scripts')
    <script src="{{ asset('js/serviceProvider.js') }}"></script>
@endpush