<div class="header-margin"></div>
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
                                        <a href="{{ route('home') }}">
                                            <span class="mr-10">Home</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                            </div>
                        </div>
                    </div>


                    <div class="row items-center x-gap-5 y-gap-20 pl-20 lg:d-none">
                        <div class="col-auto">
                            <button class="button -blue-1-05 size-50 rounded-22 flex-center">
                                <i class="icon-email-2 text-20"></i>
                            </button>
                        </div>

                        <div class="col-auto">
                            <button class="button -blue-1-05 size-50 rounded-22 flex-center">
                                <i class="icon-notification text-20"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pl-15">
                        <img src="{{ asset('assets/front') }}/img/avatars/3.png" alt="image"
                            class="size-50 rounded-22 object-cover">
                    </div>

                    <div class="d-none xl:d-flex x-gap-20 items-center pl-20" data-x="header-mobile-icons"
                        data-x-toggle="text-white">
                        <div><button class="d-flex items-center icon-menu text-20"
                                data-x-click="html, header, header-logo, header-mobile-icons, mobile-menu"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
