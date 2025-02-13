<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>My Laravel App</h1>
    </header>

    <div class="container">
        @yield('content')  <!-- Section to be replaced by child views -->
    </div>

    <footer>
        <p>&copy; 2025 My Laravel App</p>
    </footer>
</body>
</html>