@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/roomAvailability.js') }}"></script>

<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <section class="module">
                {{ HTML::ul($errors->all()) }}
                <div class="module-head">
                    <b>{{ trans('syntara::roomavailabilities.new') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'newRoomAvailabilityPost', 'id' => 'create-room-availability-form', 'method' => 'POST')) }}
                        <div class="form-group">
                            <label>{{ trans('syntara::roomavailabilities.roomtype') }}</label><br>
                            {{ Form::select('roomtype_name', array('default' => 'Select Room Type')+$roomtypes, 'default', array('id'=>'combo-room-type')) }}<br><br>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('syntara::roomavailabilities.from') }}</label><br>
                            {{ Form::text('start_date', null, array('type'=>'text', 'class'=>'form-control datepicker',
                                        'placeholder'=>'Start Date', 'id'=>'datepicker_from'))}}
                        </div><br>
                        <div class="form-group">
                            <label>{{ trans('syntara::roomavailabilities.to') }}</label><br>
                            {{ Form::text('end_date', null, array('type'=>'text', 'class'=>'form-control datepicker',
                                        'placeholder'=>'End Date', 'id'=>'datepicker_to'))}}
                        </div><br>
                        <div class="form-group">
                            <input type="button" value='{{trans('syntara::roomavailabilities.view')}}' id='view-button' class='btn btn-primary'>
                        </div>
                        
                        <div class='form-group' id='table-availability'>
                            
                        </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>
</div>
@stop