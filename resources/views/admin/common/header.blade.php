<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">

        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-language">
                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></i><span class="selected-language"> {{ Config::get('languages')[App::getLocale()]['display'] }}</span></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                    <a class="dropdown-item" href="javascript:void(0);" data-language="{{$lang}}"><i class="flag-icon flag-icon-{{$language['flag-icon']}}"></i> {{$language['display']}}</a>
                    @endif
                @endforeach
                   
                </div>
                
            </li>
           
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name font-weight-bolder">Hello</span><span class="user-status">{{auth()->user()->name}}</span></div><span class="avatar"><img class="round" src="{{asset('app-assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <!-- <a class="dropdown-item" href="#"><i class="mr-50" data-feather="user"></i> Profile</a> -->
                    <a class="dropdown-item" href="{{route('adminLogout')}}"><i class="mr-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>