@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/surcharge.js') }}"></script>
@include('syntara::layouts.dashboard.confirmation-modal', array('title' => trans('syntara::all.confirm-delete-title'), 'content' => trans('syntara::all.confirm-delete-message'), 'type' => 'delete-surcharge'))
<div class="container" id="main-container">    
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                <!-- will be used to show any messages -->
                @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif   
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.surcharges.list') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('surcharges.list-surcharges')
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
                            <label for="roomFeatureNameSearch">{{ trans('syntara::rooms.surcharges.name') }}</label>
                            <input type="text" class="form-control" id="roomFeatureNameSearch" name="roomFeatureNameSearch">
                        </div>
                        <div class="form-group">
                            <label for="roomFeatureDescriptionSearch">{{ trans('syntara::rooms.surcharges.description') }}</label>
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