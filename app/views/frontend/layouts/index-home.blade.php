@extends('frontend\layouts\master')
@section('content')
<div style='padding-left: 10px;width: 280px'>    
    <div class="clear"></div>
    <div class="search-form" style='height: 220px'>
        <div class="header-title">Your Reservation</div> 
        <div class="search-field">
        {{ Form::open(array('route' => 'searchReservation', 'id' => 'search-reservation-form', 'method' => 'POST')) }}
            <div style='padding-top: 5px;'>
                <div class='grid-50'>
                    <label>Check-in</label><br />
                    <input type="text" placeholder="Check-in" name="checkIn" class="form-control date-pic" id="checkin" />
                </div>
                <div class='grid-50'>
                    <label>Check-out</label><br />
                    <input type="text" placeholder="Check-out" name="checkOut" class="form-control date-pic" id="checkout" />
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
                <input type="submit" class='btn btn-primary' value="BOOK NOW"/>
            </div>
        {{Form::close()}}
        </div>
    </div>
</div>
<div class="grid-container" id="main-container">
    <div class='row'>
        
        <div class="col-lg-9">
            
        </div>
    </div>
</div>
@stop