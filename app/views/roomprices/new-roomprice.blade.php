@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/roomPrice.js') }}"></script>

<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <section class="module">
                {{ HTML::ul($errors->all()) }}
                <div class="module-head">
                    <b>{{ trans('syntara::roomprices.new') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'newRoomPricePost', 'id' => 'create-room-price-form', 'method' => 'POST')) }}
                        <div class="form-group">
                            <label>{{ trans('syntara::roomprices.roomtype') }}</label><br>
                            {{ Form::select('roomtype_name', array('default' => 'Select Room Type')+$roomtypes, 'default', array('id'=>'combo-room-type')) }}<br><br>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('syntara::roomprices.startDate') }}</label><br>
                            {{ Form::text('start_date', null, array('type'=>'text', 'class'=>'form-control datepicker',
                                        'placeholder'=>'Start Date', 'id'=>'datepicker_from'))}}
                        </div><br>
                        <div class="form-group">
                            <label>{{ trans('syntara::roomprices.endDate') }}</label><br>
                            {{ Form::text('end_date', null, array('type'=>'text', 'class'=>'form-control datepicker',
                                        'placeholder'=>'End Date', 'id'=>'datepicker_to'))}}
                        </div><br>
                            <label>{{ trans('syntara::roomprices.dayOfWeek') }}</label><br>
                        <div class="form-group">
                            <input type="checkbox" id="sunday" name="days[]" value="Sun">Sun
                            <input type="checkbox" id="monday" name="days[]" value="Mon">Mon
                            <input type="checkbox" id="tuesday" name="days[]" value="Tue">Tue
                            <input type="checkbox" id="wednesday" name="days[]" value="Wed">Wed
                            <input type="checkbox" id="thursday" name="days[]" value="Thu">Thu
                            <input type="checkbox" id="friday" name="days[]" value="Fri">Fri
                            <input type="checkbox" id="saturday" name="days[]" value="Sat">Sat
                            
                            <input type="button" class="btn btn-primary" style="display: inline" id="checkButton" onclick='checkAll()' value="{{trans('syntara::roomprices.checkall')}}">
                            <input type="button" class="btn btn-primary" style="display: none" id="uncheckButton" onclick='uncheckAll()' value="{{trans('syntara::roomprices.uncheckall')}}">
                        </div>
                            <script>
                                function checkAll(){
                                    document.getElementById('checkButton').style.display ='none';
                                    document.getElementById('uncheckButton').style.display ='inline';
                                    document.getElementById('sunday').checked = 'checked';
                                    document.getElementById('monday').checked = 'checked';
                                    document.getElementById('tuesday').checked = 'checked';
                                    document.getElementById('wednesday').checked = 'checked';
                                    document.getElementById('thursday').checked = 'checked';
                                    document.getElementById('friday').checked = 'checked';
                                    document.getElementById('saturday').checked = 'checked';
                                }  
                                function uncheckAll(){
                                    document.getElementById('checkButton').style.display ='inline';
                                    document.getElementById('uncheckButton').style.display ='none';
                                    document.getElementById('sunday').checked = null;
                                    document.getElementById('monday').checked = null;
                                    document.getElementById('tuesday').checked = null;
                                    document.getElementById('wednesday').checked = null;
                                    document.getElementById('thursday').checked = null;
                                    document.getElementById('friday').checked = null;
                                    document.getElementById('saturday').checked = null;
                                }
                            </script>
                            <div id="table-rate" style='display: none'>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('syntara::roomprices.allotment') }}</label>&nbsp;&nbsp;
                                <input type="text" style="max-width: 50px;max-height: 30px;text-align: center" name="allotment" value="1">&nbsp;&nbsp;
                                <label>{{ trans('syntara::roomprices.minstay') }}</label>&nbsp;&nbsp;
                                <input type="text" style="max-width: 50px;max-height: 30px;text-align: center" name="minstay" value="1">&nbsp;&nbsp;
                                <label>{{ trans('syntara::roomprices.breakfast') }}</label>&nbsp;&nbsp;
                                <input type="checkbox" style="min-width: 10px" name="breakfast" value="1">
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::submit(trans('syntara::roomprices.addTariff'), array('class' => 'btn btn-primary')) }}
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