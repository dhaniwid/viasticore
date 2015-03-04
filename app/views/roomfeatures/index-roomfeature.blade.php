@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/roomFeature.js') }}"></script>
<div class="container" id="main-container">
    @include('syntara::layouts.dashboard.confirmation-modal', array('title' => trans('syntara::all.confirm-delete-title'), 'content' => trans('syntara::all.confirm-delete-message'), 'type' => 'delete-room-feature'))
    <!-- will be used to show any messages 
    @if (Session::has('message') && Session::has('type'))          
        <div class="row status-message" id='row-message'>
            <div class="col-lg-12">
                <div class="alert alert-{{Session::get('type')}}">
                    {{ Session::get('message') }}
                </div>
            </div>        
        </div>
        <script>
            $(document).ready(function(){
                $('row-message').fadeIn(900);
            }
        </script>
    @elseif(Session::has('message'))
        <div class="row status-message" id='row-message'>
            <div class="col-lg-12">
                <div class="alert alert-info">
                    {{ Session::get('message') }}
                </div>
            </div>        
        </div>
    @endif-->
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
                   
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.features.list') }}</b>
                </div>
                <div class="module-body ajax-content">
                    @include('roomfeatures.list-roomfeatures')
                </div>
            </section>
        </div>
        {{-- <div class="col-lg-2">
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
        </div> --}}
    </div>
</div>
@stop