@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/roomSurcharge.js') }}"></script>
<script>
            $( document ).ready(function() {                
                $( "#datepicker_from_default" ).datepicker({
                    dateFormat: 'dd-mm-yy', 
                    minDate: 0, 
                    maxDate: "+2Y",
                });
                $( "#datepicker_to_default" ).datepicker({
                    dateFormat: 'dd-mm-yy', 
                    minDate: 0, 
                    maxDate: "+2Y"
                });                
                var strDate = {{ "'".$roomsurcharges->start_date."'" }};
                var dateAr = strDate.split('-');
                
                //new Date(tahun, bulan, tanggal)
                //bulan dari 0, jadi dikurangin 1
                var newDate = new Date(parseInt(dateAr[0],10), parseInt(dateAr[1],10)-1, parseInt(dateAr[2],10));                
                $("#datepicker_from_default").datepicker('setDate', newDate);                 
                var endDate = {{ "'".$roomsurcharges->end_date."'" }};
                dateAr = endDate.split('-');
                newDate = new Date(parseInt(dateAr[0],10), parseInt(dateAr[1],10)-1, parseInt(dateAr[2],10));                                
                $("#datepicker_to_default").datepicker('setDate', newDate);
            });
        </script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <section class="module">
                {{ HTML::ul($errors->all()) }}                
                <div class="module-head">
                    <b>{{ trans('syntara::roomsurcharge.edit') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'updateRoomSurchargePost', 'id' => 'update-room-surcharge-form', 'method' => 'POST')) }}
                        {{ Form::hidden('old_sur_id', $old_sur_id) }}
                        {{ Form::hidden('old_datetime', $old_datetime) }}
                        {{ Form::hidden('old_roomtype_id', $old_roomtype_id) }}
                        
                        <div class="form-group" style="margin-bottom:0px;height: 50px">
                            <label>{{ trans('syntara::roomprices.roomtype') }}</label><br>
                            {{ Form::select('roomtype_name', array('' => 'Select Room Type')+$roomtypes, $roomsurcharges->roomtype_id, array('class'=>'form-control','id'=>'combo-room-type')) }}
                        </div><br><br>
                        <div class="form-group" style="margin-bottom:0px;height: 50px">
                            <label>{{ trans('syntara::roomsurcharge.surcharge') }}</label><br>
                           {{ Form::select('surcharge', array('' => 'Select Surcharge')+$surcharge, $roomsurcharges->surcharge_id, array('class'=>'form-control','id'=>'combo-room-type')) }}
                        </div><br><br>
                        <div class="form-group">
                            <label>{{ trans('syntara::roomsurcharge.startDate') }}</label><br>
                            {{ Form::text('start_date', null, array('type'=>'text', 'class'=>'form-control datepicker',
                                        'placeholder'=>'Start Date', 'id'=>'datepicker_from_default'))}}
                        </div>
                        <div class="form-group">
                            <label>{{ trans('syntara::roomsurcharge.endDate') }}</label><br>
                            {{ Form::text('end_date', null, array('type'=>'text', 'class'=>'form-control datepicker',
                                        'placeholder'=>'End Date', 'id'=>'datepicker_to_default'))}}
                        </div><br>
                            <label>{{ trans('syntara::roomsurcharge.dayOfWeek') }}</label><br>
                        <div class="form-group" name="days">
                            <input type="checkbox" id="sunday" name="days[]" value="Sun" {{ ($roomsurcharges->dow[0]===1)? 'checked="checked"':"" }}>Sun&nbsp;
                            <input type="checkbox" id="monday" name="days[]" value="Mon" {{ ($roomsurcharges->dow[1]===1)? 'checked="checked"':"" }}>Mon&nbsp;
                            <input type="checkbox" id="tuesday" name="days[]" value="Tue" {{ ($roomsurcharges->dow[2]===1)? 'checked="checked"':"" }}>Tue&nbsp;
                            <input type="checkbox" id="wednesday" name="days[]" value="Wed" {{ ($roomsurcharges->dow[3]===1)? 'checked="checked"':"" }}>Wed&nbsp;
                            <input type="checkbox" id="thursday" name="days[]" value="Thu" {{ ($roomsurcharges->dow[4]===1)? 'checked="checked"':"" }}>Thu&nbsp;
                            <input type="checkbox" id="friday" name="days[]" value="Fri" {{ ($roomsurcharges->dow[5]===1)? 'checked="checked"':"" }}>Fri&nbsp;
                            <input type="checkbox" id="saturday" name="days[]" value="Sat" {{ ($roomsurcharges->dow[6]===1)? 'checked="checked"':"" }}>Sat&nbsp;                            
                            <input type="button" class="btn btn-primary" style="display: inline" id="checkButton" onclick='checkAll()' value="{{trans('syntara::roomprices.checkall')}}">
                            <input type="button" class="btn btn-primary" style="display: none" id="uncheckButton" onclick='uncheckAll()' value="{{trans('syntara::roomprices.uncheckall')}}">
                        </div><br>
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
                                {{ Form::radio('optional_compulsary', 'optional', ($roomsurcharges->optional==='t')? 'true':"" ) }}
                                <label>{{ trans('syntara::roomsurcharge.optional') }}</label>&nbsp;&nbsp;
                                {{ Form::radio('optional_compulsary', 'compulsary', ($roomsurcharges->optional==='f')? 'true':"" ) }}
                                <label>{{ trans('syntara::roomsurcharge.compulsary') }}</label>&nbsp;&nbsp;<br>
                                {{ Form::radio('perpax_perroom', 'perpax', ($roomsurcharges->pax==='t')? 'true':"") }}
                                <label>{{ trans('syntara::roomsurcharge.perpax') }}</label>&nbsp;&nbsp;
                                {{ Form::radio('perpax_perroom', 'perroom',($roomsurcharges->pax==='f')? 'true':"") }}
                                <label>{{ trans('syntara::roomsurcharge.perroom') }}</label>&nbsp;&nbsp;
                            </div>
                            <div class="form-group">
                            <label>{{ trans('syntara::roomsurcharge.surchargeprice') }}</label><br>
                            {{ Form::text('Price', $roomsurcharges->netprice, array('type'=>'text', 'class'=>'form-control',
                                        'placeholder'=>'Price', 'id'=>'surchargeprice'))}}
                            </div><br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::submit(trans('syntara::roomsurcharge.save'), array('class' => 'btn btn-primary')) }}
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