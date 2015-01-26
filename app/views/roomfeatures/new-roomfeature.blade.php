@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/roomFeature.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <section class="module">
                {{ HTML::ul($errors->all()) }}
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.features.new') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'newRoomFeaturePost', 'id' => 'create-room-feature-form', null)) }}
                        <div class="form-group">
                            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::rooms.features.name') }}</th>
                            <th class="col-lg-1">
                                <input class="form-control" type="text" id="roomfeature_name" name="roomfeature_name" autofocus="true">
                            </th>
                        </div>							
                        <div class="form-group">
                            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::rooms.features.description') }}</th>
                            <th class="col-lg-1">
                                <input class="form-control" type="text" id="roomfeature_description" name="roomfeature_description">
                            </th>
                        </div>                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::submit('Create Room Feature', array('class' => 'btn btn-primary')) }}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
</div>
@stop