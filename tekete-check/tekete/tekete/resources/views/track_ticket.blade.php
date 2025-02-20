@extends('layouts.user')  {{-- Extending the layout you memorized --}}

@section('title', 'Tekete Management System')


@push('topscripts')
    {{--
    <link rel="stylesheet" href="{{ asset('/css/track_ticket_side_bar2.css') }}" /> --}}
    <link href="{{ asset('css/bootstrap-4.4.1.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/track_ticket2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

@endpush

@section('content')


    <section id="demo" class="incident">



        <div class="mobile_form">
            <h1 class="title">Tekete Management System</h1>
            <div id="active">
                <div class="top-header">
                    <h5 class="active-header" onclick="active()">Active Tickets</h5>
                    <h5 class="not_active" onclick="submited()">Completed Tickets</h5>
                </div>

                @php
                    $email = session('email');
                    if ($email) {
                        $user = \App\Models\User::where('email', operator: $email)->first();
                        $incidents = $user ? $user->incidents : collect();
                    }
                @endphp

                @if(isset($incidents) && $incidents->count() > 0)
                    @foreach($incidents as $incident)
                        <div class="mobile_status">
                            <div class="mobileDiv">
                                <div class="status scroll">
                                    <h6>Ticket No: {{ $incident->date }}{{ $incident->tick_id }}</h6>
                                    <h6>Department: {{ $incident->department }}</h6>
                                    <h6>Description: {{ $incident->description }}</h6>
                                </div>
                                <div class="">
                                    <ul id="progressbar">
                                        <li class="step0 active" id="step1">LOGGED</li>
                                        <li class="step0 {{ strtoupper($incident->status) !== 'LOGGED' ? 'active' : '' }}"
                                            id="step2">IN PROGRESS</li>
                                        <li class="step0 {{ strtoupper($incident->status) === 'COMPLETED' ? 'active' : '' }}"
                                            id="step3">COMPLETED</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mobile_status">
                        <div class="mobileDiv">
                            <div style="text-align:center;margin-top:5%">
                                <h6>No Active Ticket Found</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div id="submted" style="display: none">
                <div class="top-header">
                    <h5 class="not_active" onclick="active()">Active Tickets</h5>
                    <h5 class="active-header" onclick="submited()">Completed Tickets</h5>
                </div>

                @php
                    if ($email) {
                        $user = \App\Models\User::where('email', $email)->first();
                        $completedIncidents = $user ? $user->incidents()->where('status', 'completed')->get() : collect();
                    }
                @endphp

                @if(isset($completedIncidents) && $completedIncidents->count() > 0)
                    @foreach($completedIncidents as $incidents)
                        <div class="mobile_status">
                            <div class="mobileDiv">
                                <div class="status scroll">
                                    <h6>Ticket No: {{ $incidents->date }}{{ $incidents->tick_id }}</h6>
                                    <h6>Department: {{ $incidents->department }}</h6>
                                    <h6>Description: {{ $incidents->description }}</h6>
                                </div>
                                <div class="">
                                    <ul id="progressbar">
                                        <li class="step0 active" id="step1">LOGGED</li>
                                        <li class="step0 active text-center" id="step2">IN PROGRESS</li>
                                        <li class="step0 active text-muted text-right" id="step3">COMPLETED</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mobile_status">
                        <div class="mobileDiv">
                            <div style="text-align:center;margin-top:5%">
                                <h6>No Completed Ticket Found</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '/user/details',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.user) {
                        $('#nameNoLabel').text(response.user.first_name + ' ' + response.user.last_name);
                        $('#company').text('Company: ' + (response.company ? response.company.c_name : 'N/A'));
                        $('#phoneNoLabel').text('Phone: ' + response.user.mobile);
                    } else {
                        $('#nameNoLabel').text('Name: Not Available');
                        $('#company').text('Company: Not Available');
                        $('#phoneNoLabel').text('Phone: Not Available');
                    }
                },
                error: function () {
                    console.log('Error fetching user details');
                }
            });
        });
    </script>
    <script defer src="{{ asset('/js/track_ticket.js') }}"></script>
    <script defer src="{{ asset('/js/toggle_menu.js') }}"></script>
@endpush