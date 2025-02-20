<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tekete Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <!-- Add Font Awesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="{{ asset('images/Logo 3.png') }}" alt="Tekete Logo" class="logo">
        <nav class="nav-links">
            <a href="{{ route('register') }}"><img src="{{ asset('images/user.png') }}" alt="register icon" class="register">Register</a>
            <a href="{{ route('login') }}"><img src="{{ asset('images/login.jpeg') }}" alt="login icon" class="login">Login</a>
        </nav>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif


    
    <!-- top bar -->
    <div class="topbar">
        <nav class="nav-link">
            <img src="{{ asset('images/home.jpeg') }}" alt="register icon" class="register">
            <div class="deco"></div>
        </nav>
     </div>


    <!-- Main Content -->
    <div class="main-content">
        
            <h3 class="title">Login Page</h3>

            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 1500,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please check your credentials and try again.',
                        showConfirmButton: true
                    });
                </script>
            @endif
            
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <div class="radio-group">
                    <label class="radio-label">
                        Administrator
                        <input type="radio" name="status" value="admin" required>
                    </label>
                    <label class="radio-label">
                        Service Provider
                        <input type="radio" name="status" value="Technician" required>
                    </label>
                    <label class="radio-label">
                        User
                        <input type="radio" name="status" value="User" required>
                    </label>
                </div>

                <div class="login-container">
                <div class="input-group">

                    
                    <label class="input-label" for="emailAddress">Email:</label>
                    <div class="input-container">
                    <input type="email" id="emailAddress" name="emailAddress" class="input-field" required>
                    </div>
                    @error('emailAddress')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label class="input-label" for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="input-field" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword()" title="Show/Hide Password"></i>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="btn">Login</button>
                   <!-- <button type="button" class="btn" onclick="document.getElementById('loginForm').reset()">Clear</button> -->
                </div>

                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Forgot Password</a>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>