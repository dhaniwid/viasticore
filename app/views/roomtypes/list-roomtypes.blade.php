<div class="row upper-menu">
    
    
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomType')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif
        @if($currentUser->hasAccess(Config::get('syntara::permissions.newRoomType')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newRoomType') }}">{{ trans('syntara::rooms.types.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomType')))
        <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
        @endif
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.no') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::rooms.types.name') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::rooms.types.description') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::rooms.types.status') }}</th>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomType')))
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.action') }}</th>
        @endif
    </tr>
</thead>
<tbody>    
    <?php $index=1 ?>
    @foreach ($roomtypes as $room)    
    <tr>      
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomType')))
        <td style="text-align: center;">
            <input type="checkbox" data-room-id="{{ $room->roomtype_id }}">
        </td>
        @endif
        <td style="text-align: center;">{{ $index }}</td>
        <td style="text-align: left;">
            <a href="{{ URL::route('showRoomType', $room->roomtype_id) }}">{{ $room->roomtype_name }}</a>
        </td>
        <td style="text-align: left;">{{ $room->roomtype_description }}</td>
        <td style="text-align: center;">
            @if($room->roomtype_activestatus)
                {{trans('syntara::rooms.types.active')}}            
            @else
                {{trans('syntara::rooms.types.inactive')}}            
            @endif
            
        </td>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomType')))
        <td style="text-align: center;">
            &nbsp;<a href="{{ URL::route('showRoomType', $room->roomtype_id) }}">{{ trans('syntara::all.edit') }}</a>            
        </td>
        @endif        
    </tr>
    <?php $index++ ?>
    @endforeach
</tbody>
</table>