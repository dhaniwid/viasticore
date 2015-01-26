<div class="row upper-menu">        
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomAvailability')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif
        @if($currentUser->hasAccess(Config::get('syntara::permissions.newRoomAvailability')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newRoomAvailability') }}">{{ trans('syntara::roomavailabilities.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomAvailability')))
        <!--<th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>-->
        @endif
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.no') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::roomavailabilities.name') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.occupancy') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::roomavailabilities.price') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.breakfast') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.period') }}</th>
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.dayAvailable') }}</th>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showRoomAvailability')))
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.action') }}</th>
        @endif
    </tr>
</thead>
<tbody>    
    
</tbody>
</table>