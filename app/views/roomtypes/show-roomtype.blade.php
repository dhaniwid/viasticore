@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/room.js') }}"></script>
<script>
    $(document).ready(function(){
       $("edit").click(function(){
           $("input").prop('disabled', false);
           $("edit").hide();
       });
    });
</script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-10">
            <section class="module">
            {{ HTML::ul($errors->all()) }}
            <div class="module-head">
                <b>{{ trans('syntara::rooms.types.detail') }}</b>
            </div>
            <div class="module-body">
            {{ Form::model($room, array('route' => array('putRoomType', $room->roomtype_id), 'method' => 'PUT', 'id' => 'edit-room-form')) }}			
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.name') }}</label>
                    <input class="form-control"  type="text" id="roomtype_name" name="roomtype_name" value="{{$room->roomtype_name}}" autofocus="true">
                </div>
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.max_occupancy') }}</label>
                    <input class="form-control"  type="text" id="roomtype_maxoccupancy" value="{{$room->roomtype_maxoccupancy}}" name="roomtype_maxoccupancy">
                </div>
                <div class="form-group">
                    <label class="control-label">{{ trans('syntara::rooms.types.min_availability') }}</label>
                    <input class="form-control"  type="text" id="roomtype_minavailability" value="{{$room->roomtype_minimumavailability}}" name="roomtype_minavailability">
                </div>
                <div class="form-group">
                    <label class="control-label">{{ trans('syntara::rooms.types.size') }}</label>
                    <input class="form-control"  type="text" id="roomtype_roomsize" value="{{$room->roomtype_size}}" name="roomtype_roomsize">
                </div>
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.room_extrabed') }}</label>
                    <input class="form-control"  type="text" id="roomtype_extrabed" name="roomtype_extrabed" value="{{$room->roomtype_extrabed}}">
                </div>
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.room_extrabed_price') }}</label>
                    <input class="form-control"  type="text" id="roomtype_extrabedprice" name="roomtype_extrabedprice" value="{{$room->roomtype_extrabedprice}}">
                </div>
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.min_room_price') }}</label>
                    <input class="form-control"  type="text" id="roomtype_lowestprice" name="roomtype_lowestprice" value="{{$room->roomtype_lowestprice}}">
                </div>
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.status') }}</label>
                    <!--<input class="form-control"  type="text" id="roomtype_activestatus" name="roomtype_activestatus" value="{{$room->roomtype_activestatus}}">-->
                    <br>
                    @if($room->roomtype_activestatus == 1)
                        {{ Form::radio('roomtype_activestatus', $room->roomtype_activestatus)}}
                        {{ trans('syntara::rooms.types.active') }}<br>
                        {{ Form::radio('roomtype_activestatus') }}
                        {{ trans('syntara::rooms.types.inactive') }}
                    @else
                        {{ Form::radio('roomtype_activestatus')}}
                        {{ trans('syntara::rooms.types.active') }}<br>
                        {{ Form::radio('roomtype_activestatus',  $room->roomtype_activestatus) }}
                        {{ trans('syntara::rooms.types.inactive') }}
                    @endif
                    
                </div> 
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.description') }}</label>
                    <input class="form-control"  type="text" id="roomtype_description" name="roomtype_description" value="{{$room->roomtype_description}}">
                </div>
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.facilities') }}</label>
                    <ul class="checkbox-neat">
                        @foreach ($roomcontents as $content)
                        <li>
                        {{ Form::checkbox('room_features[]', $content->roomfeature_id, $content->checked) }}
                        {{ $content->roomfeature_name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <!--<input type="button" id="edit-button" class="btn btn-primary" value="Edit Room" onclick="checkMode(false)">-->
                            {{ Form::submit(trans('syntara::all.update'), array('class' => 'btn btn-primary', 'id'=>'edit-button')) }}
                            <input type="button" id="cancel-button" class="btn btn-primary" style="display: none" value="Cancel" onclick="checkMode(true)">
                            <script>
                                function checkMode(e){
                                    if(e){
                                        //if this is cancel button clicked / update process finished
                                        document.getElementById('update-button').style.display = 'none';
                                        document.getElementById('cancel-button').style.display = 'none';
                                        document.getElementById('edit-button').style.display = 'inline';                                        
                                        $("input").prop('disabled', e);
                                    }
                                    else{
                                        //else if this is edit button clicked
                                        document.getElementById('edit-button').style.display = 'none';
                                        document.getElementById('update-button').style.display = 'inline';
                                        document.getElementById('cancel-button').style.display = 'inline';                                                                            
                                        $("input").prop('disabled', e);
                                    }                                    
                                };
                            </script>                            
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
            <!-- UPLOAD IMAGE FORM -->
            <section class="module">
            <div class="module-body">
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.types.upload') }}</b>
                </div>
            {{ Form::open(array('route' => array('uploadRoomImage', $room->roomtype_id), 'files'=>true, 'method'=> 'POST', 'id' => 'upload-image-form')) }}
                <div class="form-group">
                    <label>{{ trans('syntara::rooms.types.image') }}</label><br>
                    <th class="input-control">
                        @if(count($roomimages))
                            @foreach ($roomimages as $image)
                            <img src="{{$image->roomimage_description}}" id="roomimage" />
                            @endforeach  
                    </th><br><br>
                            </script> 
                        @else  <br><img src="{{ asset('packages/mrjuliuss/syntara/assets/img/alert/no_preview.png')}}" id="screenshot" />
                        @endif
                    <th>    
                        <br><br>
                    <div class="form-group">
                        <input class="form-control" type="file" id="roomimage_name" name="image" onchange="readURL(this);">
                    </div>
                        <br><img src="" id="screenshot" width="" height="" /></input>
                        <br>
                            <script type="text/javascript">
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                            $('#screenshot').attr('src', e.target.result);
                                            $('#screenshot').attr('width', '280');
                                            $('#screenshot').attr('height', '200');
                                    };

                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                            </script>
                    </th>
                </div>
                <div class="row">
                    <div class="col-lg-10">
                        {{ Form::submit(trans('syntara::rooms.types.upload'), array('class' => 'btn btn-primary', 'id'=>'upload-button')) }}
                        {{ Form::reset('Clear', array('class' => 'btn btn-primary', 'id'=>'clear-button', 'onclick' => 'clearURL()')) }}
                    </div>
                </div>
            {{Form::close()}}       
            </div>
            </section>
            <a href="{{ URL::previous() }}" class="btn btn-primary">Go Back</a>            
            </div>            
            </section>            
        </div>            
    </div>
</div>
@stop