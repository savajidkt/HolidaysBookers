
<header data-add-bg="" class="header -dashboard bg-white js-header" data-x="header" data-x-toggle="is-menu-opened">
    <div data-anim="fade" class="header__container px-30 sm:px-20">
        <div class="-left-side">
            <a href="{{ route('agent.dashboard') }}" class="header-logo" data-x="header-logo" data-x-toggle="is-logo-dark">
                <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="logo icon">
                <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="logo icon">
            </a>
        </div>

        <div class="row justify-between items-center pl-60 lg:pl-20">
            <div class="col-auto">
                <div class="d-flex items-center">
                    <button data-x-click="dashboard">
                        <i class="icon-menu-2 text-20"></i>
                    </button>


                </div>
            </div>

            <div class="col-auto">
                <div class="d-flex items-center">

                    <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
                        <div class="mobile-overlay"></div>

                        <div class="header-menu__content">
                            <div class="mobile-bg js-mobile-bg"></div>

                            <div class="menu js-navList">
                                <ul class="menu__nav text-dark-1 fw-500 -is-active">
                                    <li>
                                        <a href="{{ route('home') }}" class="rounded-100 bg-blue-1 text-white">
                                            <span class="">Home</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}">
                                            <span class="mr-10">Hotel</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}">
                                            <span class="mr-10">Transfer</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}">
                                            <span class="mr-10">Sightseeing</span>
                                        </a>
                                    </li>                                                                     
                                </ul>
                            </div>
                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                            </div>
                        </div>
                    </div>
                   
                    
                </div>
            </div>
        </div>
    </div>
</header>
