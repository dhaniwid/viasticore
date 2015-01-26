<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.date') }}</th>
            <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::roomavailabilities.day') }}</th>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.reserved') }}</th>
            <th class="col-lg-2" style="text-align: center;">{{ trans('syntara::roomavailabilities.guaranteed') }}</th>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.availability') }}</th>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.minstay') }}</th>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.closeout') }}</th>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.noarrival') }}</th>
            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::roomavailabilities.promoblackout') }}</th>
        </tr>
    </thead>
    <tbody>        
    @foreach($roomAvailabilities as $roomAvailability)
    <tr>
        <td style="vertical-align: middle"><input type='text' class='form-control' style='min-width: 100px' readonly="true" name='roomavailability_date[]' value='{{$roomAvailability->roomavailability_date}}'</td>
        <td style="vertical-align: middle"><input type='text' class='form-control' style='min-width: 50px' readonly value='{{$roomAvailability->roomavailability_day}}'</td>
        <td style="vertical-align: middle; text-align: center"><input type='text' class='form-control' style='min-width: 40px' readonly name='roomavailability_reserved[]' value='{{$roomAvailability->roomavailability_reserved}}'</td>
        <td style="vertical-align: middle; text-align: center"><input type='text' class='form-control' style='min-width: 40px' readonly name='roomavailability_guaranteed[]' value='{{$roomAvailability->roomavailability_guaranteed}}'</td>
        <td style="vertical-align: middle; text-align: center"><input style='text-align: center' type='text' style='min-width: 40px' class='form-control' name='roomavailability_number[]' value='{{$roomAvailability->roomavailability_number}}'></td>
        <td style="vertical-align: middle; text-align: center"><input style='text-align: center' type='text' style='min-width: 40px' class='form-control' name='roomavailability_minstay[]' value='{{$roomAvailability->roomavailability_minstay}}'></td>
        <td style="vertical-align: middle; text-align: center"><input type='checkbox' name='roomavailability_closeout[]'></td>
        <td style="vertical-align: middle; text-align: center"><input type='checkbox' name='roomavailability_noarrival[]'></td>
        <td style="vertical-align: middle; text-align: center"><input type='checkbox' name='roomavailability_promoblackout[]'></td>
        <input type='hidden' name='roomavailability_closeout[]' value="1">
        <input type='hidden' name='roomavailability_noarrival[]' value="1">
        <input type='hidden' name='roomavailability_promoblackout[]' value="1">
    </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {{ Form::submit(trans('syntara::roomprices.addTariff'), array('class' => 'btn btn-primary')) }}
        </div>
    </div>
</div>