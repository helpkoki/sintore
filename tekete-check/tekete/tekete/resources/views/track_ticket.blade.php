<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tekete Management System</title>
    <link rel="stylesheet" href="{{ asset('/css/track_ticket_side_bar2.css') }}" />
    <link href="{{ asset('css/bootstrap-4.4.1.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/track_ticket2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <label style="color: blue" id="nameNoLabel">
                        {{ session('name', 'Guest') }}
                    </label>&nbsp;

                    <a class="nav-link glyphicon glyphicon-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"></a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="email" href="#">
                            <label style="color: blue">
                                {{ session('email', 'Not Available') }}
                            </label>
                        </a>
                        <a class="dropdown-item" id="phoneNo" href="#">
                            <label id="phoneNoLabel">Phone:</label>
                        </a>
                        <a class="dropdown-item" id="company" href="#">
                            <label id="companyLabel">Company: Not Available</label>
                        </a>
                        <a class="dropdown-item" id="logout" href="{{ url('logout') }}">
                            <label style="color: blue">Logout</label>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End of Topbar -->

    <section id="demo" class="incident">
        <div class="sidebar" id="sidebar">
            <div class="admin">
                <center>
                    <img src="{{ asset('images/logo.png') }}" class="logo" alt="" />
                </center>
            </div>
            <div class="items">
                <a  href="{{ route('log_ticket.create') }}">
                    <i class="fa fa-envelope" aria-hidden="true"></i>Log a ticket
                </a>
            </div>
            <div class="items">
                <a  href="{{ route('track_ticket') }}">
                    <i class="fa fa-traffic-light" aria-hidden="true"></i>Track ticket
                </a>
            </div>
        </div>

        <div class="incident-form"></div>

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
                        $user = \App\Models\User::where('email', $email)->first(); // Assuming you have a User model
                        $incidents = $user ? $user->incidents : collect(); // Assuming a relationship exists
                        //$incidents = $user ? $user->incidents()->where('status','!=','completed')->get() : collect();
                    }
                @endphp

                @if(isset($incidents) && $incidents->count() > 0)
                    @foreach($incidents as $incident)
                        @if(strtoupper($incident['status']) == 'ESCALATE')
                            <div class="mobile_status">
                                <div class="mobileDiv">
                                    <div class="status scroll">
                                        <h6>Ticket No: {{ $incident->date }}{{ $incident->tick_id }}</h6>
                                        <h6>Department: {{ $incident->department }}</h6>
                                        <h6>Description: {{ $incident->description }}</h6>
                                    </div>
                                    <div class="">
                                        <div class="">
                                            <ul id="progressbar">
                                                
                                                <li class="step0 active" id="step1">LOGGED</li>
                                                <li class="step0 active text-center" id="step2">IN PROGRESS</li>
                                                <li class="step0 active text-muted text-right" id="step3">{{ strtoupper($incident->status) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif(strtoupper($incident['status']) == 'IN-PROGRESS')
                            <div class="mobile_status">
                                <div class="mobileDiv">
                                    <div class="status scroll">
                                        <h6>Ticket No: {{ $incident->date }}{{ $incident->tick_id }}</h6>
                                        <h6>Department: {{ $incident->department }}</h6>
                                        <h6>Description: {{ $incident->description }}</h6>
                                    </div>
                                    <div class="">
                                        <div class="">
                                            <ul id="progressbar">
                                                
                                                <li class="step0 active" id="step1">LOGGED</li>
                                                <li class="step0 active text-center" id="step2">IN PROGRESS</li>
                                                <li class="step0  text-muted text-right" id="step3">COMPLETED</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif(strtoupper($incident['status']) == 'LOGGED')
                            <div class="mobile_status">
                                <div class="mobileDiv">
                                    <div class="status scroll">
                                        <h6>Ticket No: {{ $incident->date }}{{ $incident->tick_id }}</h6>
                                        <h6>Department: {{ $incident->department }}</h6>
                                        <h6>Description: {{ $incident->description }}</h6>
                                    </div>
                                    <div class="">
                                        <div class="">
                                            <ul id="progressbar">
                                                
                                                <li class="step0 active" id="step1">LOGGED</li>
                                                <li class="step0 text-center" id="step2">IN PROGRESS</li>
                                                <li class="step0 text-muted text-right" id="step3">COMPLETED</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                            
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
                        // Fetch completed incidents
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
                                    <div class="">
                                        <ul id="progressbar">
                                            <li class="step0 active" id="step1">LOGGED</li>
                                            <li class="step0 active text-center" id="step2">IN PROGRESS</li>
                                            <li class="step0 active text-muted text-right" id="step3">COMPLETED</li>
                                        </ul>
                                    </div>
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

    <script>
        $(document).ready(function () {
            $.ajax({
                url: '/user/details',  // Adjust the route as necessary
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.user && response.user.first_name && response.user.email && response.user.mobile) {
                        $('#nameNoLabel').text(response.user.first_name + ' ' + response.user.last_name);
                        $('#company').text('Company: ' + (response.company ? response.company.c_name : 'N/A'));
                        $('#phoneNoLabel').text('Phone: ' + response.user.mobile);
                    } else {
                        $('#nameNoLabel').text('Name: Not Available');
                        $('#company').text('Company: Not Available');
                        $('#phoneNoLabel').text('Phone: Not Available');
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error fetching user details:', error);
                    $('#nameNoLabel').text('Name: Error');
                    $('#email').text('Email: Error');
                    $('#phoneNoLabel').text('Phone: Error');
                }
            });
        });
    </script>
    <script defer src="{{ asset('/js/track_ticket.js') }}"></script>
    <script defer src="{{ asset('/js/toggle_menu.js') }}"></script>
</body>
</html>