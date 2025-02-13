<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav>
        <ul>
            <li>
                <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo">
            </li>
            <li>
                <a href="{{ url('/') }}"><i class="bi bi-house-door"></i></a>    
            </li>
            <li class="deco"></li>
            <!-- <li>
                <label style="color: blue" id="nameNoLable">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </label>
                <img src="{{ asset('images/user.jpg') }}" class="icon" alt="User">
            </li> -->
        </ul>
    </nav>

    <div class="sidebar">
        <br>
        <br>
        <br>
        <br>
        <a href="#"><i class="bi bi-stack"></i> Dashboard</a>
        <a href="#"><i class="bi bi-check-circle"></i> Status</a>
        <a href="#"><i class="bi bi-person"></i> Admin</a>
        <a href="#"><i class="bi bi-person"></i> Service Provider</a>
        <a href="#"><i class="bi bi-gear"></i> Settings</a>
    </div>

    <div class="main-content">
        <h1>Registration Page</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="first_name">Name</label>
                <input type="text" id="first_name" name="first_name" 
                       value="{{ old('first_name') }}" required>
                @error('first_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Surname</label>
                <input type="text" id="last_name" name="last_name" 
                       value="{{ old('last_name') }}" required>
                @error('last_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mobile">Cellphone No</label>
                <input type="text" id="mobile" name="mobile" 
                       value="{{ old('mobile') }}" required>
                @error('mobile')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="company_id">Company Name</label>
                <select id="company_id" name="company_id" required>
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->company_id }}">{{ $company->c_name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" 
                       name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit">Register</button>
                <button type="reset">Clear</button>
            </div>
        </form>
    </div>
</body>
</html>