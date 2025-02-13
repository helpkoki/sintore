<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify OTP - Tekete Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
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
            <h1 class="title">Verify OTP</h1>

            @if(session('status'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('status') }}',
                        showConfirmButton: true
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ $errors->first() }}',
                        showConfirmButton: true
                    });
                </script>
            @endif

            <form method="POST" action="{{ route('password.verify.otp') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="input-group">
                    <label class="input-label" for="otp">Enter OTP:</label>
                    <input type="text" id="otp" name="otp" class="input-field" required maxlength="6" pattern="\d{6}">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>