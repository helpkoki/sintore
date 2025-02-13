<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - Tekete Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="sidebar">
        <img src="{{ asset('images/Logo 3.png') }}" alt="Tekete Logo" class="logo">
        <nav class="nav-links">
            <a href="{{ route('login') }}">Back to Login</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="login-container">
            <h1 class="title">Reset Password</h1>

            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        showConfirmButton: true
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error!',
                        text: '{{ $errors->first() }}',
                        showConfirmButton: true
                    });
                </script>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="input-group">
                    <label class="input-label" for="email">Email:</label>
                    <input type="email" id="email" class="input-field" value="{{ $email }}" disabled>
                </div>

                <div class="input-group">
                    <label class="input-label" for="password">New Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="input-field" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword('password')" title="Show/Hide Password"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="password_confirmation">Confirm Password:</label>
                    <div class="password-container">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" required>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword('password_confirmation')" title="Show/Hide Password"></i>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn">Reset Password</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/reset.js') }}"></script>
</body>
</html>