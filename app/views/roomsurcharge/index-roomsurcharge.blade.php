@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/roomSurcharge.js') }}"></script>
@include('syntara::layouts.dashboard.confirmation-modal', array('title' => trans('syntara::all.confirm-delete-title'), 'content' => trans('syntara::roomsurcharge.confirm-delete-message'), 'type' => 'delete-room-surcharge'))
<div class="container" id="main-container">    
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('syntara::roomsurcharge.list') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('roomsurcharge.list-roomsurcharge')
                </div>
            </section>
        </div>        
    </div>
</div>
@stop