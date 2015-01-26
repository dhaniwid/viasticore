@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/occupancy.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-6">
            <section class="module">
                <div class="module-head">
                    <b>{{ trans('syntara::occupancies.new') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'newOccupancyPost', 'method'=>'POST', 'id' => 'create-occupancy-form', 'class="form-horizontal"')) }}
                    <div class="row">
                        <div class="col-lg-12">    
                            <div class="form-group">
                                <label class="control-label">{{ trans('syntara::occupancies.id') }}</label>
                                <p><input class="col-lg-12 form-control" type="text" id="occupancy_id" name="occupancy_id" autofocus="true"></p>
                            </div>							
                            <div class="form-group">
                                <label class="control-label">{{ trans('syntara::occupancies.description') }}</label>
                                <p><input class="col-lg-12 form-control" type="text" id="occupancy_description" name="occupancy_description"></p>
                            </div>                        
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::submit('Create Occupancy', array('class' => 'btn btn-primary')) }}
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