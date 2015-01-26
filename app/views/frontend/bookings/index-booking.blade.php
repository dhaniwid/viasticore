@extends('frontend\layouts\master')

@section('content')
<div class="grid-container" id='main-container'>    
    @include('frontend.bookings.list-bookings')
</div>
@stop