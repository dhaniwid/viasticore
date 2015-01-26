@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/room.js') }}"></script>
@include('syntara::layouts.dashboard.confirmation-modal', array('title' => trans('syntara::all.confirm-delete-title'), 'content' => trans('syntara::rooms.confirm-delete-message'), 'type' => 'delete-room-type'))
<div class="container" id="main-container">    
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.types.list') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('roomtypes.list-roomtypes')
                </div>
            </section>
        </div>
        <div class="col-lg-2">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('syntara::all.search') }}</b>
                </div>
                <div class="module-body">
                    <form id="search-form" onsubmit="return false;">
                        <div class="form-group">
                            <label for="roomFeatureNameSearch">{{ trans('syntara::rooms.features.name') }}</label>
                            <input type="text" class="form-control" id="roomFeatureNameSearch" name="roomFeatureNameSearch">
                        </div>
                        <div class="form-group">
                            <label for="roomFeatureDescriptionSearch">{{ trans('syntara::rooms.features.description') }}</label>
                            <input type="text" class="form-control" id="roomFeatureDescriptionSearch" name="roomFeatureDescriptionSearch">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('syntara::all.search') }}</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@stop