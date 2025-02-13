<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Service Provider Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: white;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .topbar {
            height: 60px;
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            background-color: #f8f9fa;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .content {
            /* margin-left: 250px; */
            margin-top: 60px;
            padding: 1rem;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="width: 70px; height: 70px;">
        </div>
        <nav>
        <ul class="list-unstyled">
    <li class="mb-2 dropdown">
        <a class="dropdown-toggle fs-4" style="color: #C1CE61;" href="#" id="dashboardDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-speedometer2 me-2 text-dark"></i> Dashboard
        </a>
        <ul class="dropdown-menu" aria-labelledby="dashboardDropdown">
            <li><a class="dropdown-item fs-4" href="{{ route('technician.dashboard') }}">
                <i class="bi bi-graph-up me-2"></i> Analytics & Overview</a>
            </li>
        </ul>
            </li>
            <li class="mb-2 dropdown">
                <a class="dropdown-toggle fs-4" style="color: #C1CE61;" href="#" id="statusDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-check-circle me-2 text-success"></i> Status
                </a>
                <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                    <li><a class="dropdown-item text-primary fs-4" href="{{ route('technician.logged') }}">
                        🔵 Logged</a>
                    </li>
                    <li><a class="dropdown-item text-warning fs-4" href="{{ route('technician.in_progress') }}">
                        🟡 In-progress</a>
                    </li>
                    <li><a class="dropdown-item text-danger fs-4" href="{{ route('technician.escalated') }}">
                        🔴 Escalate</a>
                    </li>
                    <li><a class="dropdown-item text-success fs-4" href="{{ route('technician.completed') }}">
                        🟢 Completed</a>
                    </li>
                </ul>
            </li>
        </ul>
        </nav>
    </div>

    <!-- Top Navigation -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <a href="#" class="fs-4 me-3 text-primary"><i class="bi bi-house"></i></a>
            <input type="text" class="form-control d-inline-block" style="width: 200px;" placeholder="Search...">
        </div>
        <div>
            <a href="#" class="fs-4 me-3 text-dark"><i class="bi bi-bell"></i></a>
            <a href="#" class="fs-4 me-3 text-dark"><i class="bi bi-chat-dots"></i></a>
            <a href="#" class="fs-4 me-3 text-dark"><i class="bi bi-gear"></i></a>
            <a href="#" class="fs-4 text-dark"><i class="bi bi-person-circle"></i></a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @stack('scripts')
</body>

</html>