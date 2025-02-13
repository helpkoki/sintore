<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tekete Management System</title>
        <link href="{{ asset('/css/bootstrap-4.4.1.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/jAlert.css') }}" />
        <link rel="stylesheet" href="{{ asset('/css/log_ticket.css') }}">
        <script src="{{ asset('/js/log_ticket.js?v=0.1.5') }}"></script>
        <!--script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        
        <!-- Correct jQuery version -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!--img src="{{-- asset('/images/homeicon.png') --}}" class="logo" alt="Tekete Logo"-->

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <!--div class="user">
                            <!--img src="{{-- asset('images/usericon.png') --}}" alt="User  Icon"-->
                        <!--/div-->

                        <label style="color: blue" id="nameNoLable">
                            {{ session('name', 'Guest') }}
                        </label>&nbsp;

                        <!--a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"-->
                        <a class="nav-link glyphicon glyphicon-user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" id="email" href="#">
                                Email: 
                                <span>
                                    {{ session('email', 'Not Available') }}
                                </span>
                            </a>
                            <a class="dropdown-item" id="phoneNo" href="#">
                                <label id="phoneNoLabel">Phone:</label>
                            </a>
                            <a class="dropdown-item" id="company" href="#">
                                Company: Not Available
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item" style="margin: 0; padding: 0;">
                                @csrf
                                <button type="submit" id="logout" class="dropdown-item" style="width: 100%; text-align: left; background: none; border: none;">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="incident">
            <div class="sidebar" id="sidebar">
                <div class="items">
                    <center>
                        <img src="{{ asset('images/logo.png') }}" class="sidebar-logo" alt="Home Logo">
                    </center>
                </div>
                <div class="items">
                    <a href="{{ url('/log_ticket') }}">
                        <i class="fa fa-envelope" aria-hidden="true"></i> Log a Ticket
                    </a>
                </div>
                <div class="items">
                    <a href="{{ url('/track_ticket') }}">
                        <i class="fa fa-traffic-light" aria-hidden="true"></i> Track Ticket
                    </a>
                </div>
                <div class="items">
                    <a href="{{ url('settings') }}">
                        <i class="fa fa-gear" aria-hidden="true"></i> Settings
                    </a>
                </div>
            </div>
        </section>

        <h1 class="title">Tekete Management System</h1>
                  @if(session('success'))
                  <script>
                        swal.fire({
                        title: "Success!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                        // Optionally redirect after the alert
                        window.location.href = "{{ url('log_ticket') }}"; 
                        });
                  </script>
                   @elseif(session('error'))
                  <script>
                        swal.fire({
                        title: "Error!",
                        text: "{{ session('error') }}",
                        icon: "error",
                        button: "OK",
                     });
                  </script>
                @endif
        <div class="incident-form">
            <form name="frm" id="frm" action="{{ route('log_ticket.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <table class="table">
                    <tr>
                        <td style="vertical-align:middle" class="labels"> <a>DATE:</a></td>
                        <td style="vertical-align:middle"><input type="text" class="input-text" id="date" value="" readonly> </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle" class="labels"> <a>Operating System:</a> </td>
                        <td>
                            <select name="os" id="operating-system" required class='input-text'>
                                <option class="option" value=""> Select</option>
                                <option class="option" value="Windows"> Windows </option>
                                <option class="option" value="Mac "> Mac</option>
                                <option class="option" value="Android"> Android</option>
                                <option class="option" value="Linux"> Linux</option>
                            </select>
                            <span class="error">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle" class="labels"> <a>Department:</a></td>
                        <td>
                            <select name="department" id="department" required class='input-text'>
                                <option value="" class="option"> Select</option>
                                <option class="option" value="support">support</option>
                                <option class="option" value="Multimedia">Multimedia</option>
                                <option class="option" value="Development">Development</option>
                                <option class="option" value="Bussiness Analysis">Bussiness Analysis</option>
                                <option class="option" value="Project Management">Project Management</option>
                            </select>
                            <span class="error">* </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle" class="labels"> <a>Description:</a> </td>
                        <td>
                            <select name="description" id="description" required onchange="otherVal()" class='input-text'>
                                <option value="" class="option"> Select</option>
                                <option class="option" value="forgotten password">forgotten password</option>
                                <option class="option" value="Slow performance">Slow performance</option>
                                <option class="option" value="USB unrecognised">USB unrecognised</option>
                                <option class="option" value="Computer randomly shutsdown">Computer randomly shutsdown</option>
                                <option class="option" value="Network Problem">Network Problem</option>
                                <option class="option" value="Other" id="Other">Other</option>
                            </select>
                            <span class="error">* </span>
                        </td>
                    </tr>
                    <tr id="other_te" hidden>
                        <td style="vertical-align:middle" class="labels"><a>Other:</a></td>
                        <td><input id="otherValue" class="input-text" type="text" name="other_text" placeholder="Other" required value="" onchange="changeValue()"><span class="error">*</span></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle" class="labels"><a>Attachment</a></td>
                        <td><input id="attachment" class="input-text" type="file" name="attachment" accept="image/*"></td>
                    </tr>
                    <tr>
                        <td><input class="submit_btn" type="submit" name="log" /></td>
                        <td><input class="clear_btn" type="button" onclick="clearField()" value="Clear" name="clear"></td>
                    </tr>
                </table>
            </form>
        </div>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: '/user/details',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.user && response.user.first_name) {
                            // Update the name label with full name
                            $('#nameNoLable').text(response.user.first_name + ' ' + response.user.last_name);
                            $('#company').text('Company: ' + (response.company ? response.company.c_name : 'N/A'));
                            $('#phoneNoLabel').text('Phone: ' + response.user.mobile);
                        } else {
                            $('#nameNoLable').text('Guest');
                            $('#company').text('Company: Not Available');
                            $('#phoneNoLabel').text('Phone: Not Available');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Error fetching user details:', error);
                        $('#nameNoLable').text('Guest');
                        $('#company').text('Company: Error');
                        $('#phoneNoLabel').text('Phone: Error');
                    }
                });
            });           
        </script>
    </body>
</html>



         