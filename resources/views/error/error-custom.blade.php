@extends('base.error-base')

@section('content')
    <p>{{ $error_msg }}</p>
    <p>you can go <a href="/">home</a></p>
@endsection
