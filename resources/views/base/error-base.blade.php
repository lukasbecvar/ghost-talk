<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href={{ asset('build/css/error-page.css') }}>
    <link rel="icon" href={{ asset('build/images/favicon.png') }} type="image/x-icon"/> 
    <title>Ghost Talk</title>
</head>
<body>
    <center>
        @yield('content', 'Unknown error')
    </center>
</body>
</html>
