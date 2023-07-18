<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <h1 class="text-warning">Hello</h1>
    <div class="container">
        <div class="mt-2">
            @yield('content')
        </div>
    </div>
</body>
</html>
