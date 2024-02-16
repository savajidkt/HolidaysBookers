
<header data-add-bg="" class="header -dashboard bg-white js-header" data-x="header" data-x-toggle="is-menu-opened">
    <div data-anim="fade" class="header__container px-30 sm:px-20">
        <div class="-left-side-logo">
            <a href="{{ route('agent.dashboard') }}" class="header-logo" data-x="header-logo" data-x-toggle="is-logo-dark">
                <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="logo icon">
                <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="logo icon">
            </a>
        </div>

        <div class="row justify-between items-center lg:pl-20">
            <div class="col-auto">
                <div class="d-flex items-center">
                    <button id="toggleButton" data-x-click="dashboard">
                        <i id="icon" class="icon-menu-2 text-20"></i>
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
                                        <a href="{{ route('home') }}" class="button header-login-btn">
                                            <span class="">Home</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}" class="button header-login-btn">
                                            <span class="mr-10">Hotel</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}" class="button header-login-btn">
                                            <span class="mr-10">Transfer</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('home') }}" class="button header-login-btn">
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

<style>
ul.menu__nav.text-dark-1.fw-500.-is-active {
    display: flex;
    align-items: center;
    gap: 10px;
}
    .header .header-logo img {
    width: 65%;
}

a.button.header-login-btn {
    padding: 0 25px !important;
    height: 45px;
    background-color: #091136;
    color: #fff;
    border-radius: 50px;
}
a.button.header-login-btn:hover{
background-color: transparent;
    border: 1px solid #EE1C25;
    color: #EE1C25 !important;
}
</style>
<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        var icon = document.getElementById('icon');
        if (icon.classList.contains('icon-menu-2')) {
            icon.classList.remove('icon-menu-2');
            icon.classList.add('icon-close');
        } else {
            icon.classList.remove('icon-close');
            icon.classList.add('icon-menu-2');
        }
    });
</script>