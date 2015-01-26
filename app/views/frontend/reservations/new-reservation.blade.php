<div class="box-reg">
    <div class="header-title">{{trans('syntara::reservations.list')}}</div>
    <div class="domestic-hotel">
        @foreach($reservations as $reservation)
        <div class="clear"></div>
        <div class="item-booking">
            <div class="grid-25 tablet-grid-40 mobile-grid-100 grid-parent">
                <img src="{{$reservation->roomimage_description}}" height="120px" width='200px' />  
            </div>
            <div class="grid-50 tablet-grid-40 mobile-grid-100 grid-parent">
                <div class="room-name">{{$reservation->roomtype_name}}</div>           
                <div class='room-description' style="height: 70px">{{$reservation->roomtype_description}}</div>
                <div>{{$reservation->occupancy_description}} {{trans('syntara::reservations.room')}}</div>
            </div>               
            <div class="grid-10 tablet-grid-40 mobile-grid-100 grid-parent">
                <div class="occupancy-box">
                    <div class="user-box" style="height: 80px">
                        Max<br>
                        @if($reservation->occupancy_id == 1)
                            <i class="glyphicon glyphicon-user"></i>
                        @else
                            @for($idx = 0; $idx < $reservation->occupancy_id; $idx++)
                                <i class="glyphicon glyphicon-user"></i>
                            @endfor
                        @endif 
                    </div>
                    <div class="clear"></div>
                    {{trans('syntara::reservations.room')}}<br>
                    <!-- Loop room numbers -->
                    <select name="numberOfRooms">
                        @for($count=1;$count<=$reservation->roomavailability_number;$count++)
                        <option value="{{$count}}">{{$count}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="grid-10 tablet-grid-20 mobile-grid-20 grid-parent">  
                <span class="room-price">@currency( $reservation->roomprice_rate, 'IDR')</span><br>
                {{HTML::linkRoute('createBooking',trans('syntara::reservations.bookNow'), 
                            base64_encode(json_encode(array('roomtype_id' => $reservation->roomtype_id,
                                            'roomtype_name' => $reservation->roomtype_name,
                                            'occupancy_id' => $reservation->occupancy_id,
                                            'check_in' => $searchingDates->checkInDate, 
                                            'check_out' => $searchingDates->checkOutDate,
                                            'occupancy_id' => $reservation->occupancy_id,
                                            'occupancy_description' => $reservation->occupancy_description,
                                            'roomprice_rate' => $reservation->roomprice_rate,
                                            'roomimage_description' => $reservation->roomimage_description,
                                            'number_of_room' => $reservation->roomavailability_number))),
                    array('class' => 'btn btn-primary'))}}
            </div>
            <div class="clear"></div>
        </div>   
        <div class='dashed-line' style='padding-top:10px'></div>
        @endforeach 
    </div>
</div>
