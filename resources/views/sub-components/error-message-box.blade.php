<!-- error msg (only if error found) -->
@if ($error_msg)
    <p class="error-message">
        error: {{ $error_msg }}
    </p>
@endif