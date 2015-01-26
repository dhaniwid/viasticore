<div class="navbar main-bar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ (!empty($siteUrl)) ? $siteUrl : '/'}} " target="_new">
            {{ (!empty($siteName)) ? $siteName : "VIASTICORE"}}

            <div class="visible-sm"><img class="ajax-loader ajax-loader-sm" src="{{ asset('packages/mrjuliuss/syntara/assets/img/ajax-load.gif') }}" style="float: right;"/></div>
        </a>
    </div>

    <div class="navbar-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
            <li class=""><a href="{{ URL::route('listRoomRates') }}"><i class="glyphicon glyphicon-book"></i> <span>{{ trans('syntara::rooms.rates') }}</span></a></li>
            <li class=""><a href="#"><i class="glyphicon glyphicon-bookmark"></i> <span>{{ trans('syntara::rooms.promos') }}</span></a></li>
            <li class=""><a href="#"><i class="glyphicon glyphicon-font"></i> <span>{{ trans('syntara::all.contact') }}</span></a></li>
        </ul>

        @if(Sentry::check())
        <ul class="nav navbar-nav navbar-{{ (Config::get('syntara::config.direction') === 'rtl') ? 'left' : 'right' }}">
            <li class="hidden-sm"><img class="ajax-loader ajax-loader-lg" src="{{ asset('packages/mrjuliuss/syntara/assets/img/ajax-load.gif') }}" style="float: right;"/></li>
            {{ (!empty($navPagesRight)) ? $navPagesRight : '' }}
            <li><a href="{{ URL::route('showUser', Sentry::getUser()->id ) }}"><span class="text">{{ Sentry::getUser()->username }}</span></a></li>
            <li><a title="Logout" href="{{ URL::route('logout') }}"><i class="glyphicon glyphicon-share-alt"></i> <span class="text">{{ trans('syntara::navigation.logout') }}</span></a></li>
        </ul>
        @endif
    </div>
</div>