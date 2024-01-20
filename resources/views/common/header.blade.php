@if (Route::has('hotel-details'))
    <header data-add-bg="" class="header bg-white " data-x="header" data-x-toggle="is-menu-opened">
    {{-- <header data-add-bg="" class="header -fixed bg-white js-header" data-x="header" data-x-toggle="is-menu-opened"> --}}
    @else
    <header data-add-bg="" class="header bg-white shadow-3 js-header" data-x="header" data-x-toggle="is-menu-opened">
@endif
<div class="container">
<div data-anim="fade 12" class="header__container">
    <div class="sub-header justify-between items-center">
        <div class="col-auto">
            <div class="header-hb-logo-menu">
                <a href="{{ url('/') }}" class="header-logo" data-x="header-logo"
                    data-x-toggle="is-logo-dark">
                    <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="logo icon">
                </a>
                <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
                    <div class="mobile-overlay"></div>

                    <div class="header-menu__content">
                        <div class="mobile-bg js-mobile-bg"></div>

                        <div class="menu js-navList">
                            <ul class="menu__nav text-dark-1 -is-active">
                                <li>
                                    <a href="{{ route('home') }}">
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('about-us') }}">
                                        About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-us') }}">
                                        Contact Us
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('offers') }}">Offers</a>
                                </li>
                            </ul>
                        </div>

                        <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-auto">
            <div class="d-flex items-center">

                {{-- <div class="row x-gap-20 items-center xxl:d-none">
                        <div class="col-auto">
                            <button class="d-flex items-center text-14 text-dark-1" data-x-click="currency">
                                <span class="js-currencyMenu-mainTitle">USD</span>
                                <i class="icon-chevron-sm-down text-7 ml-10"></i>
                            </button>
                        </div>

                        <div class="col-auto">
                            <div class="w-1 h-20 bg-black-20"></div>
                        </div>

                        <div class="col-auto">
                            <button class="d-flex items-center text-14 text-dark-1" data-x-click="lang">
                                <img src="{{ asset('assets/front') }}/img/general/lang.png" alt="image"
                                    class="rounded-full mr-10">
                                <span class="js-language-mainTitle">United Kingdom</span>
                                <i class="icon-chevron-sm-down text-7 ml-15"></i>
                            </button>
                        </div>
                    </div> --}}


                <div class="d-flex items-center ml-20 is-menu-opened-hide md:d-none main-login-btn">

                    @guest

                        <a href="{{ route('adminLogin') }}"
                            class="button header-login-btn">Become
                            An Expert</a>
                    @else
<?php  
                       
                        
                            $user = Auth::user(); 
                            $c_code = "";
                            if( $user->user_type == '1' ){
                                $c_code = getUserWiseGlobalCurrency($user->agents->agent_country);  
                            } else if( $user->user_type == '2' ){
                                $c_code = getUserWiseGlobalCurrency($user->usermeta->country_id);  
                            }
                                                            
                            
                                          
                                           
                        ?>
                        <button class="d-flex items-center text-14 text-dark-1">
                            <span class="js-currencyMenu-mainTitle">{{ $c_code }}</span>
                            
                        </button>

                        <a class="button"
                            href="{{ route('cart') }}">
                            <i class="fa" style="font-size:24px">&#xf07a;</i>
                            <sup class='badge badge-warning' id='lblCartCount'> {{ getCartTotalItem() }} </sup>
                        </a>
                        <a class="button header-login-btn"
                            href="{{ route('agent.dashboard') }}">
                            {{ __('Dashboard') }}
                        </a>
                    @endguest
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                                class="button header-login-btn">Sign In</a>
                        @endif
                    @else
                        <a class="button header-login-btn logout"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        
                    @endguest
                </div>



                <div class="d-none xl:d-flex x-gap-20 items-center pl-30" data-x="header-mobile-icons"
                    data-x-toggle="text-white">
                    <div><a href="login.html" class="d-flex items-center icon-user text-inherit text-22"></a>
                    </div>
                    <div><button class="d-flex items-center icon-menu text-inherit text-20"
                            data-x-click="html, header, header-logo, header-mobile-icons, mobile-menu"></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</header>
