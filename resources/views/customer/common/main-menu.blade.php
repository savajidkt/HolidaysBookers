<div class="dashboard__sidebar bg-white scroll-bar-1">

    <div class="sidebar__user text-center mb-20">
        <div class="logo">
            @php
                $user = auth()->user(); 
            @endphp
            <div class="avatar avatar-cover"
                style="background-image: url('{{ isset($user->userMeta->user_avatar) && strlen($user->userMeta->user_avatar) > 0 ? url(Storage::url('app/upload/avatar/' . $user->id . '/' . $user->usermeta->user_avatar)) : 'https://gotrip.bookingcore.org/images/avatar.png' }}')"></div>
        </div>

        
        <div class="user-profile-info">
            <div class="info-new">
                <span class="role-name badge badge-info">customer</span>
                <h5 class="text-16">Jayesh Patel</h5>
                <p class="text-10 mb-0">Member Since May 2023</p>
            </div>
        </div>
    </div>
    <div class="sidebar -dashboard">
        <div class="sidebar__item">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div
                            class="sidebar__button {{ $pagename == 'dashboard' ? 'active -is-active text-blue-1' : '' }} col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('customer.dashboard') }}" class="icon text-center mr-15 text-24"><i
                                        class="fa fa-dashboard"></i></a>
                                <a href="{{ route('customer.dashboard') }}">
                                    Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div
                            class="sidebar__button {{ $pagename == 'booking-history' ? 'active -is-active text-blue-1' : '' }} col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('customer.booking-history', 'all') }}"
                                    class="icon text-center mr-15 text-24"><i class="fa fa-clock-o"></i></a>
                                <a href="{{ route('customer.booking-history', 'all') }}">
                                    Booking History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div
                            class="sidebar__button {{ $pagename == 'wishlist' ? 'active -is-active text-blue-1' : '' }} col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('customer.wishlist') }}" class="icon text-center mr-15 text-24"><i
                                        class="fa fa-heart-o"></i></a>
                                <a href="{{ route('customer.wishlist') }}">
                                    Wishlist
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div
                            class="sidebar__button {{ $pagename == 'verifications' ? 'active -is-active text-blue-1' : '' }} col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('customer.verification') }}"
                                    class="icon text-center mr-15 text-24"><i class="fa fa-handshake-o"></i></a>
                                <a href="{{ route('customer.verification') }}">
                                    Verifications
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div
                            class="sidebar__button {{ $pagename == 'my-profile' ? 'active -is-active text-blue-1' : '' }}  col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('customer.my-profile') }}" class="icon text-center mr-15 text-24"><i
                                        class="fa fa-cogs"></i></a>
                                <a href="{{ route('customer.my-profile') }}">
                                    My Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div
                            class="sidebar__button {{ $pagename == 'change-password' ? 'active -is-active text-blue-1' : '' }} col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('customer.my-change-password') }}"
                                    class="icon text-center mr-15 text-24"><i class="fa fa-lock"></i></a>
                                <a href="{{ route('customer.my-change-password') }}">
                                    Change password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item ">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="sidebar__button d-flex items-center text-15 lh-1 fw-500">
                <i class="fa fa-sign-out icon text-center mr-15 text-24"></i> Log Out
            </a>
        </div>
        <div class="sidebar__item ">
            <a href="{{ route('home') }}" class="sidebar__button d-flex items-center text-15 lh-1 fw-500">
                <i class="fa fa-long-arrow-left icon text-center mr-15 text-24"></i> Back to Homepage
            </a>
        </div>
    </div>
</div>
