<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @stack('styles')
</head>
<body>
    @yield('modal-content')
    @stack('scripts')
</body>
</html>