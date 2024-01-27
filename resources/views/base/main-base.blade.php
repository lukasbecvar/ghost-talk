<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="Private encrypted chat" name="description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href={{ asset('build/css/main.css') }}>
    <link rel="stylesheet" href={{ asset('build/css/scrollbar.css') }}>
    <link rel="icon" href={{ asset('build/images/favicon.png') }} type="image/x-icon"/> 
    <title>Ghost Talk</title>
</head>
<body>

    <noscript>
        <meta http-equiv="refresh" content="0;url=/error/nojs">
    </noscript>
    
    <!-- navigation component-->
    @include('sub-components.navigation')

    <!-- main component -->
    <div class="main-container">
        @yield('content')
    </div>
</body>
</html>
