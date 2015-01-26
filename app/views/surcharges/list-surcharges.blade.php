<div class="row upper-menu">
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteSurcharge')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif

        @if($currentUser->hasAccess(Config::get('syntara::permissions.newSurcharge')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newSurcharge') }}">{{ trans('syntara::rooms.surcharges.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteSurcharge')))
        <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
        @endif
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.no') }}</th>
        <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::rooms.surcharges.description') }}</th>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showSurcharge')))
        <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::all.action') }}</th>
        @endif
    </tr>
</thead>
<tbody>    
    <?php $index=1 ?>
    @foreach ($surcharges as $surcharge)    
    <tr>      
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteSurcharge')))
        <td style="text-align: center;">
            <input type="checkbox" data-surcharge-id="{{ $surcharge->surcharge_id }}">
        </td>
        @endif
        <td style="text-align: center;">{{ $index }}</td>
        <td style="text-align: left;">{{ $surcharge->surcharge_description }}</td>
        @if($currentUser->hasAccess(Config::get('syntara::permissions.showSurcharge')))
        <td style="text-align: center;">
            &nbsp;<a href="{{ URL::route('editSurcharge', $surcharge->surcharge_id) }}">{{ trans('syntara::all.edit') }}</a>                        
        </td>
        @endif        
    </tr>
    <?php $index++ ?>
    @endforeach
</tbody>
</table>