<div class="row upper-menu">
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomFeature')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif

        @if($currentUser->hasAccess(Config::get('syntara::permissions.newRoomFeature')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newRoomFeature') }}">{{ trans('syntara::rooms.features.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomFeature')))
        <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
        @endif
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.no') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::rooms.features.name') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::rooms.features.description') }}</th>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomFeature')))
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.action') }}</th>
        @endif
    </tr>
</thead>
<tbody>    
    <?php $index=1 ?>
    @foreach ($roomfeatures as $room)    
    <tr>      
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomFeature')))
        <td style="text-align: center;">
            <input type="checkbox" data-room-feature-id="{{ $room->roomfeature_id }}">
        </td>
        @endif
        <td style="text-align: center;">{{ $index }}</td>
        <td style="text-align: left;">{{ $room->roomfeature_name }}</td>
        <td style="text-align: left;">{{ $room->roomfeature_description }}</td>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomFeature')))
        <td style="text-align: center;">
            &nbsp;<a href="{{ URL::route('editRoomFeature', $room->roomfeature_id) }}">{{ trans('syntara::all.edit') }}</a>            
        </td>
        @endif        
    </tr>
    <?php $index++ ?>
    @endforeach
</tbody>
</table>