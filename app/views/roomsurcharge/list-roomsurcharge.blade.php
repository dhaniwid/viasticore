<div class="row upper-menu">        
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomSurcharge')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif
        @if($currentUser->hasAccess(Config::get('syntara::permissions.newRoomSurcharge')))        
        <a class="btn btn-info btn-new" href="{{ URL::route('newRoomSurcharge') }}">{{ trans('syntara::roomsurcharge.new') }}</a>        
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomSurcharge')))
            <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
            @endif
            <th>{{ trans('syntara::roomsurcharge.no') }}</th>
            <th>{{ trans('syntara::roomsurcharge.start_date') }}</th>
            <th>{{ trans('syntara::roomsurcharge.end_date') }}</th>
            <th>{{ trans('syntara::roomsurcharge.room_type') }}</th>
            <th>{{ trans('syntara::roomsurcharge.surcharge') }}</th>
            <th>{{ trans('syntara::roomsurcharge.optional') }}</th>
            <th>{{ trans('syntara::roomsurcharge.perpax') }}</th>
            <th>{{ trans('syntara::roomsurcharge.surchargeprice') }} </td>
            @if($currentUser->hasAccess(Config::get('syntara::permissions.editRoomSurcharge')))
                <th>{{ trans('syntara::roomsurcharge.delete') }}</th>
            @endif
        </tr>        
    </thead>
    <tbody><!-- $date,$surcharge_id,$room_type_id -->
        @foreach ($roomsurcharge as $key=> $rs )
        <tr>
             @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomSurcharge')))
            <td style="text-align: center;">
                <input type="checkbox" data-room-id="{{ $rs->datetime,"|",$rs->surcharge_id,"|",$rs->roomtype_id }}">
            </td>
            @endif
            <td>{{ $key+1 }}</td>
            <td>{{ $rs->start_date }}</td>
            <td>{{ $rs->end_date }}</td>
            <td>{{ $rs->roomtype_name }}</td>
            <td>{{ $rs->surcharge_desc }}</td>
            <td>{{ $rs->optional==='t'?"Optional":"Compulsary" }}</td>
            <td>{{ $rs->pax==='t'?"Per Pax":"Per Room" }}</td>
            <td>{{ $rs->netprice }}</td>
            @if($currentUser->hasAccess(Config::get('syntara::permissions.editRoomSurcharge')))
                <td><a class="btn-new" href="{{ URL::route('editRoomSurcharge',array($rs->datetime,$rs->surcharge_id,$rs->roomtype_id)) }}">{{ trans('syntara::roomsurcharge.edit') }}</a></td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>