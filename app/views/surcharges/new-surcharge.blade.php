@extends(Config::get('syntara::views.master'))

@section('content')
<script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/surcharge.js') }}"></script>
<div class="container" id="main-container">
    <div class="row">
        <div class="col-lg-12">
            <section class="module">
                {{ HTML::ul($errors->all()) }}
                <div class="module-head">
                    <b>{{ trans('syntara::rooms.surcharges.new') }}</b>
                </div>
                <div class="module-body">
                    {{ Form::open(array('route' => 'newSurchargePost', 'id' => 'create-surcharge-form', null)) }}
                        <div class="form-group">
                            <th class="col-lg-1" style="text-align: center;">{{ trans('syntara::rooms.surcharges.description') }}</th>
                            <th class="col-lg-1">
                                <input class="form-control" autofocus="true" type="text" id="surcharge_description" name="surcharge_description">
                            </th>
                        </div>                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::submit('Create Surcharge', array('class' => 'btn btn-primary')) }}
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