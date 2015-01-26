<div class="row upper-menu">        
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomPrice')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif
        @if($currentUser->hasAccess(Config::get('syntara::permissions.newRoomPrice')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newRoomPrice') }}">{{ trans('syntara::roomprices.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomPrice')))
        <!--<th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>-->
        @endif
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.no') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::roomprices.name') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomprices.occupancy') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::roomprices.price') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomprices.breakfast') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomprices.period') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomprices.dayAvailable') }}</th>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomPrice')))
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.action') }}</th>
        @endif
    </tr>
</thead>
<tbody>    
    <?php $index=1; $lastIndex=1; ?>
    <?php $tempRoomPriceDateTime = null; $tempRoomPriceDate = null; $tempRoomOccupancy=0; ?>
    @foreach ($roomprices as $room)    
    <tr>
        @if($room->roomprice_datetime != $tempRoomPriceDateTime)            
            <td style="text-align: center;" rowspan="{{$room->max_occupancy}}">{{ $index }}</td>
            <td style="text-align: left;" rowspan="{{$room->max_occupancy}}">{{$room->roomtype_name}}</td>
            <?php $index++ ?>
        @endif
        @if($room->occupancy_id != $tempRoomOccupancy)
            <?php $tempRoomOccupancy=$room->occupancy_id ?>                
        <td style="text-align: left;">{{$room->occupancy_description}}</td>
        <td style="text-align: right;">{{ $room->roomprice_rate }}</td>
        <td style="text-align: center;">
            @if($room->roomprice_breakfast)
                {{trans('syntara::roomprices.included')}}            
            @else
                {{trans('syntara::roomprices.notIncluded')}}            
            @endif            
        </td>
        
        <td style="text-align: left;">{{ $room->start_date }} to {{ $room->end_date}}</td>
        <td style="text-align: left;">{{$room->roomprice_date}}</td>
            @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomPrice')))
                @if($room->roomprice_datetime != $tempRoomPriceDateTime)
                <td rowspan="{{$room->max_occupancy}}" style="text-align: center;">
                    &nbsp;<a href="{{ URL::route('showRoomPrice', array($room->roomprice_datetime, 
                                $room->occupancy_id, $room->roomtype_id)) }}">{{ trans('syntara::all.edit') }}</a>            
                </td>
                @endif
            @endif
            <?php $tempRoomPriceDateTime=$room->roomprice_datetime ?>
        @endif
    </tr>    
    @endforeach
</tbody>
</table>