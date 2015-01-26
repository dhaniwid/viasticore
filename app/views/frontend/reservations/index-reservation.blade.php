@extends('frontend\layouts\master')
@section('content')
<script>
    $(document).ready(function(){
        
    });
    
    $('#changeDate').click(function() {
        $('#search-form').toggle();
    });
</script>
<div class="grid-100">
    <div class='grid-25'>
        <div style='padding-left: 10px;width: 280px'>    
            <div class="clear"></div>
            <div class="search-form" style='height: 235px'>
                <div class="header-title">Reservation Summary</div> 
                <div id='reservation-summary' style="padding: 5px">
                    <div class='grid-100'>
                        {{$searchingDates->checkInDate}} - {{$searchingDates->checkOutDate}}
                    </div>
                    <div class="grid-100">
                        {{$searchingDates->night}} Night, {{$searchingDates->roomQty}} Room
                    </div>
                    <div class='grid-100'>
                        {{$searchingDates->adultQty}} Adult, {{$searchingDates->childQty}} Child
                    </div>
                    <div class='dashed-line' style='padding-top:10px;padding-bottom: 5px'></div>
                </div>                
                <div id='search-form' class="search-field" style='display: none'>
                {{ Form::open(array('route' => 'searchReservation', 'id' => 'search-reservation-form', 'method' => 'POST')) }}
                    <div style='padding-top: 5px;'>
                        <div class='grid-50'>
                            <label>Check-in</label><br />
                            <input type="text" placeholder="Check-in" name="checkIn" value='{{$searchingDates->checkInDate}}' class="form-control date-pic" id="checkin" />
                        </div>
                        <div class='grid-50'>
                            <label>Check-out</label><br />
                            <input type="text" placeholder="Check-out" name="checkOut" value="{{$searchingDates->checkOutDate}}" class="form-control date-pic" id="checkout" />
                        </div>
                    </div>           
                    <div class='clear'></div>
                    <div style='padding-left: 5px;padding-top: 10px'>
                        <div class='grid-30'>
                            <label>Adult</label><br />
                            {{Form::select('adultQty',array('1' => 1, '2' => 2), null, array('class'=>'form-control'))}}
                        </div>
                        <div class='grid-30'>
                            <label>Child</label><br />
                            {{Form::select('childQty',array('0' => 0, '1'=>1, '2'=>2), 0, array('class'=>'form-control'))}}
                        </div>
                        <div class='grid-30'>
                            <label>Room</label><br />
                            {{Form::select('roomQty',array('1'=>1, '2'=>2, '3'=>3, '4'=>4, '5'=>5), 0, array('class'=>'form-control'))}}
                        </div>
                    </div>
                    <div class='clear'></div>
                    <div style='text-align: right;padding-top: 15px;padding-right: 10px'>
                        <input type="submit" id='changeDate' class='btn btn-primary' value="CHANGE DATE"/>
                    </div>                    
                {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="grid-65">
        @include('frontend.reservations.new-reservation')
    </div>
</div>
@stop