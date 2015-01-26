@extends(Config::get('syntara::views.master'))

@section('content')
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <section class="module">
            {{ HTML::ul($errors->all()) }}
            <div class="module-head">
                <b>{{ trans('syntara::rooms.features.edit') }}</b>
            </div>
            <div class="module-body">
            {{ Form::model($room, array('route' => array('putRoomFeature', $room->roomfeature_id), 'method' => 'PUT')) }}			
                <div class="form-group">
                    <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::rooms.features.name') }}</th>
                    <th class="col-lg-1">
                        <input class="form-control" type="text" id="roomfeature_name" name="roomfeature_name" autofocus="true" value="{{$room->roomfeature_name}}">
                    </th>
                </div>							
                <div class="form-group">
                    <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::rooms.features.description') }}</th>
                    <th class="col-lg-1">
                        <input class="form-control" type="text" id="roomfeature_description" name="roomfeature_description" value="{{$room->roomfeature_description}}">
                    </th>
                </div>							
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                                {{ Form::submit('Update Room Facility', array('class' => 'btn btn-primary')) }}
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