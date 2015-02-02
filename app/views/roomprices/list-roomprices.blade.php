<script>
            $( document ).ready(function() {                
                $( "#datepicker_from_default" ).datepicker({
                    dateFormat: 'dd-mm-yy', 
                    minDate: 0, 
                    maxDate: "+2Y",
                });
                $( "#datepicker_to_default" ).datepicker({
                    dateFormat: 'dd-mm-yy', 
                    minDate: 0, 
                    maxDate: "+2Y"
                });            
                var now=new Date();   
                <?php if(!empty($start_date)){ ?>
                    var strDate = $start_date;
                    var dateAr = strDate.split('-');

                    //new Date(tahun, bulan, tanggal)
                    //bulan dari 0, jadi dikurangin 1
                    var newDate = new Date(parseInt(dateAr[0],10), parseInt(dateAr[1],10)-1, 
                                    parseInt(dateAr[2],10));                
                    $("#datepicker_from_default").datepicker('setDate', newDate);                 
                    var endDate = $end_date;                    
                    dateAr = endDate.split('-');
                    newDate = new Date(parseInt(dateAr[0],10), parseInt(dateAr[1],10)-1, parseInt(dateAr[2],10));                                
                    $("#datepicker_to_default").datepicker('setDate', newDate);
                <?php } else { ?>                    
                    $("#datepicker_from_default").datepicker('setDate', new Date());
                    $("#datepicker_to_default").datepicker('setDate', new Date(+new Date + 12096e5));
                <?php }?>
                                
            });
        </script>
<div class="row upper-menu">      
    {{ Form::open(array('route' => 'searchListPrice', 'id' => 'search-room-price-form', 'method' => 'POST')) }}
<table width="1000px" >
    <tr>
        <td style="padding: 10px"><div class="form-group" >
                <label>{{ trans('syntara::roomprices.roomtype') }}</label><br>
            {{ Form::select('roomtype_id', array('' => 'Select Room Type')+$roomtypes, $roomtype_id,array('class'=>'form-control','style'=>'width:100%')) }}
            </div></td>
        <td style="padding: 10px">
            <div class="form-group">
                <label>{{ trans('syntara::roomprices.startDate') }}</label><br>
                {{ Form::text('start_date', $start_date, array('type'=>'text', 'class'=>'form-control datepicker',
                            'placeholder'=>'Start Date', 'id'=>'datepicker_from_default'))}}
            </div>
        </td>
        <td>
            <div class="form-group">
                <label>{{ trans('syntara::roomprices.endDate') }}</label><br>
                {{ Form::text('end_date', $end_date, array('type'=>'text', 'class'=>'form-control datepicker',
                            'placeholder'=>'End Date', 'id'=>'datepicker_to_default'))}}
            </div>
        </td>
        <td>
            {{ Form::submit(trans('syntara::roomprices.search'),array('class'=>'btn btn-info btn-new')) }}
            {{-- <a class="btn btn-info btn-new" href="{{ URL::route('newRoomPrice') }}">{{ trans('syntara::roomprices.search') }}</a> --}}
        </td>
</tr>
</table>
{{ Form::close() }}
    <div style="float:right;">
        @if($currentUser->hasAccess(Config::get('syntara::permissions.deleteRoomPrice')))
        <a id="delete-item" class="btn btn-danger">{{ trans('syntara::all.delete') }}</a>
        @endif
        @if($currentUser->hasAccess(Config::get('syntara::permissions.newRoomPrice')))
        <a class="btn btn-info btn-new" href="{{ URL::route('newRoomPrice') }}">{{ trans('syntara::roomprices.new') }}</a>
        @endif
    </div>
</div>
@if(isset($listView))
<div style ="width: 1000px; border:0px; overflow-x:scroll; white-space: nowrap;">
{{ Form::open(array('route' => 'editListPrice', 'id' => 'update-room-price-form', 'method' => 'POST')) }}
{{ Form::hidden('roomtype_id', $roomtype_id) }}
{{ Form::hidden('start_date', $start_date) }}
{{ Form::hidden('end_date', $end_date) }}
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        <th class="col-lg-1" rowspan="2" style="text-align: center;width: 50px">{{ trans('syntara::all.no') }}</th>
        
        <th class="col-lg-2" width="500px"  rowspan="2" style="text-align: center;width: 200px">{{ trans('syntara::roomprices.date') }}</th>
        @for ($i = 0; $i < $room_occ; $i++)
            <th class="col-lg-2" colspan="2" style="text-align: center;width: 300px">{{$occText[$i]}}</th>
        @endfor                
    </tr>
    <tr>
        @for ($i = 0; $i < $room_occ; $i++)
            <th class="col-lg-1" style="text-align: center;width: 150px">{{ trans('syntara::roomprices.price') }}</th>        
        <th class="col-lg-1" style="text-align: center;width: 150px">{{ trans('syntara::roomprices.breakfast') }}</th>
        @endfor                                
    </tr>
    
</thead>
<tbody>
    
    <?php $index=1; ?>
    @foreach ($pricelist as $date=>$pl)
        <tr>
            <td>{{ $index++ }}</td>
            <td>{{$date}}</td>
            @foreach ($pl as $key=>$pl_occ)
                <td>
                    <input type="text" name="{{$occText[$key-1]."[$date]"."[rate]"}}" value="{{$pl_occ->roomprice_rate}}"/>
                </td>
                <td>
                    <input type="text" name="{{$occText[$key-1]."[$date]"."[breakfast]"}}" value="{{$pl_occ->roomprice_breakfast}}"/>                    
                    {{ Form::hidden($occText[$key-1]."[$date]"."[extrabed]", $pl_occ->roomprice_extrabed) }}
                    {{ Form::hidden($occText[$key-1]."[$date]"."[status]", $pl_occ->roomprice_status) }}
                    
                </td>
            @endforeach
        </tr>
    @endforeach
</tbody>
</table>
<div style="float:right;">
@if($currentUser->hasAccess(Config::get('syntara::permissions.editListPrice')))
    {{Form::submit('Save',array('class'=>'btn btn-info btn-new'))}}
@endif
</div>
{{ Form::close() }}
</div>
@endif