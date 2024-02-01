@extends('base.error-base')

@section('content')
    <p>Sorry, your device is currently in an unsupported position. To access this feature, please rotate your device to landscape mode or use a device with a wider screen</p>

    <script>
        function isHeightPosition() {
            return window.orientation === 0 || window.orientation === 180;
        }

        function redirectIfHeightPosition() {
            if (!isHeightPosition()) {
                window.location.href = "/";
            }
        }

        window.onload = redirectIfHeightPosition;
        window.addEventListener("orientationchange", redirectIfHeightPosition);
    </script>
@endsection
