<!doctype html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>@yield('title', '')</title>
    @stack('styles')
</head>

<body>
    @yield('content')

    @include('layouts.script')
    @stack('scripts')
</body>

</html>
