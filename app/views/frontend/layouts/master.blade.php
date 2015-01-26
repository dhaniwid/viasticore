<html>
    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/booking.main-1.0.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/booking.payment-1.0.css') }}" />
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/unsemantic-grid-responsive-tablet.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/css/bootstrap.min.css') }}" />
        @if(Config::get('syntara::config.direction') === 'rtl')
            <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/css/bootstrap-rtl.min.css') }}" media="all"/>
            <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/css/base-rtl.css') }}" media="all"/>
        @endif
        <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/css/toggle-switch.css') }}" />
        <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/themes/smoothness/jquery-ui.css') }}"/>
        
        <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/css/base.css') }}" media="all"/>
         @if(Config::get('syntara::config.direction') === 'rtl')
            <link rel="stylesheet" href="{{ asset('packages/mrjuliuss/syntara/assets/css/base-rtl.css') }}" media="all"/>
        @endif

        @if (!empty($favicon))
        <link rel="icon" {{ !empty($faviconType) ? 'type="' . $faviconType . '"' : '' }} href="{{ $favicon }}" />
        @endif        
        <script src="{{ asset('packages/mrjuliuss/syntara/assets/js/jquery-2.1.1.min.js') }}"></script>        
        <script src="{{ asset('packages/mrjuliuss/syntara/assets/js/jquery-2.1.3.js') }}"></script>        
        <script src="{{ asset('packages/mrjuliuss/syntara/assets/js/jquery-ui.js') }}"></script>
        <script src="{{ asset('packages/mrjuliuss/syntara/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('packages/mrjuliuss/syntara/assets/js/dashboard/base.js') }}"></script>
        <script type="text/javascript" src="{{asset('assets/js/main.js')}}"></script>   
        <script type="text/javascript" src="{{asset('assets/js/ticktab.payment-1.0.js')}}"></script>   
        
        <script>
            $(function() {
                $( "#datepicker_from" ).datepicker({
                    dateFormat: 'dd-mm-yy', 
                    minDate: 0, 
                    maxDate: "+2Y",
                });
                $( "#datepicker_to" ).datepicker({
                    dateFormat: 'dd-mm-yy', 
                    minDate: 0, 
                    maxDate: "+2Y"
                });
                
                $("#datepicker_from").datepicker('setDate', new Date());
                $("#datepicker_to").datepicker('setDate', new Date(+new Date + 12096e5));
            });
        </script>
        <title>{{ (!empty($siteName)) ? $siteName : "The Viasticore Hotel"}} - {{isset($title) ? $title : 'Home' }}</title>
    </head>
    <body>
        @include('frontend\layouts\header')
        {{ isset($breadcrumb) ? Breadcrumbs::create($breadcrumb) : ''; }}
        <div>
            @yield('content')
        </div>
        <div class='footer'></div>
    </body>
</html>
