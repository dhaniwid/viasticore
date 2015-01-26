@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/room.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <section class="module">
                {{ HTML::ul($errors->all()) }}
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.types.new') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'newRoomTypePost', 'id' => 'create-room-form', null)) }}
                        <div class="form-group">
                            <label>{{ trans('syntara::rooms.types.name') }}</label>
                            <input class="form-control" type="text" id="roomtype_name" name="roomtype_name" autofocus="true">
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.max_occupancy') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_maxoccupancy" name="roomtype_maxoccupancy">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.min_availability') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_minavailability" name="roomtype_minavailability">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.size') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_roomsize" name="roomtype_roomsize">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.room_extrabed') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_extrabed" name="roomtype_extrabed">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.room_extrabed_price') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_extrabedprice" name="roomtype_extrabedprice">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.min_room_price') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_lowestprice" name="roomtype_lowestprice">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.status') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_activestatus" name="roomtype_activestatus">
                            </th>
                        </div> 
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.description') }}</th>
                            <th>
                                <input class="form-control" type="text" id="roomtype_description" name="roomtype_description">
                            </th>
                        </div>
                        <div class="form-group">
                            <th style="text-align: center;">{{ trans('syntara::rooms.types.facilities') }}</th>
                            <ul class="checkbox-neat">
                                @foreach ($roomfeatures as $feature)
                                <li>
                                <input type="checkbox" name="room_features[]" value="{{ $feature->roomfeature_id }}">
                                {{ $feature->roomfeature_name }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::submit(trans('syntara::rooms.types.create'), array('class' => 'btn btn-primary')) }}
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