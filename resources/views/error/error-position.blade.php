@extends('base.error-base')

@section('content')
    <script>
        function isHeightPosition() {
            return window.orientation === 0 || window.orientation === 180;
        }

        function redirectIfHeightPosition() {
            if (!isHeightPosition()) {
                // redirect users in landscape position back to index
                window.location.href = "/";
            }
        }

        // check orientation on page load
        window.onload = redirectIfHeightPosition;

        // listen for orientation changes
        window.addEventListener("orientationchange", redirectIfHeightPosition);
    </script>

    <p>Sorry, your device is currently in an unsupported position. To access this feature, please rotate your device to landscape mode or use a device with a wider screen</p>
@endsection
