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
<h1>Completed Tickets</h1>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ticket No</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Priority</th>
                <th>Technician</th>
                <th>Survey</th>
            </tr>
        </thead>
        <tbody>
            @if(count($tickets) > 0)
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->date }}/{{ $ticket->tick_id }}</td>
                        <td>{{ $ticket->user_first_name }} {{ $ticket->user_last_name }}</td>
                        <td>{{ $ticket->user_mobile }}</td>
                        <td>{{ $ticket->user_email }}</td>
                        <td>{{ $ticket->priority }}</td>
                        <td>{{ $ticket->tech_first_name }} {{ $ticket->tech_last_name }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">No completed tickets found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection