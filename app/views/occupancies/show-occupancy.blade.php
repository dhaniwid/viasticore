@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/occupancy.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <section class="module">
            {{ HTML::ul($errors->all()) }}
            <div class="module-head">
                <b>{{ trans('syntara::occupancies.edit') }}</b>
            </div>
            <div class="module-body">
            {{ Form::model($occupancy, array('route' => array('putOccupancy', $occupancy->occupancy_id), 'id'=>'edit-occupancy-form', 'method' => 'PUT')) }}			
                <div class="form-group">
                    <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::occupancies.id') }}</th>
                    <th class="col-lg-1">
                        <input class="form-control" type="text" disabled id="occupancy_id" name="occupancy_id" autofocus="true" value="{{$occupancy->occupancy_id}}">
                    </th>
                </div>							
                <div class="form-group">
                    <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::occupancies.description') }}</th>
                    <th class="col-lg-1">
                        <input class="form-control" type="text" id="occupancy_description" name="occupancy_description" value="{{$occupancy->occupancy_description}}">
                    </th>
                </div>							
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                                {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
            </div>
            </section>
        </div>
    </div>
</div>
@stop