<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href={{ asset('build/css/main.css') }}>
    <title>laravel app</title>
</head>
<body>
    @yield('content')
    <script src={{ asset('build/js/main.js') }}></script>
</body>
</html>
