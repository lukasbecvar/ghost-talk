@extends('base.main-base') 

@section('content')
<div class="chat-component">
    @include('components.chat-list')
    @include('components.chat')
</div>
@endsection
