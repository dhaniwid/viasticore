<div class="row upper-menu">
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteOccupancy')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif

        @if($currentUser->hasAccess(Config::get('syntara::permissions.newOccupancy')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newOccupancy') }}">{{ trans('syntara::occupancies.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteOccupancy')))
        <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
        @endif
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::occupancies.id') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::occupancies.description') }}</th>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showOccupancy')))
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.action') }}</th>
        @endif
    </tr>
</thead>
<tbody>    
    <?php $index=1 ?>
    @foreach ($occupancies as $occupancy)    
    <tr>      
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteOccupancy')))
        <td style="text-align: center;">
            <input type="checkbox" data-occupancy-id="{{ $occupancy->occupancy_id }}">
        </td>
        @endif
        <td style="text-align: center;">{{ $occupancy->occupancy_id }}</td>
        <td style="text-align: left;">{{ $occupancy->occupancy_description }}</td>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showOccupancy')))
        <td style="text-align: center;">
            &nbsp;<a href="{{ URL::route('showOccupancy', $occupancy->occupancy_id) }}">{{ trans('syntara::all.edit') }}</a>            
        </td>
        @endif        
    </tr>
    <?php $index++ ?>
    @endforeach
</tbody>
</table>