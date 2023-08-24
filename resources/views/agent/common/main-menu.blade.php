<div class="dashboard__sidebar bg-white scroll-bar-1">

    <div class="sidebar__user text-center mb-20">
        <div class="logo">
            @php
                $user = auth()->user();
            @endphp

            @if($user->userMeta->user_avatar)
                <div class="avatar avatar-cover"
                    style="background-image: url('{{ isset($user->userMeta->user_avatar) && strlen($user->userMeta->user_avatar) > 0 ? url(Storage::url('app/upload/avatar/' . $user->id . '/' . $user->usermeta->user_avatar)) : 'https://gotrip.bookingcore.org/images/avatar.png' }}')">
                </div>
            @else
                <div class="avatar avatar-cover"
                    style="background-image: url('{{ url(Storage::url('app/upload/avatar/avatar.png')) }}')">
                </div>
            @endif
           
        </div>


        <div class="user-profile-info">
            <div class="info-new">
                <span class="role-name badge badge-info">Agent</span>
                <h5 class="text-16">{{ $user->first_name }} {{ $user->last_name }}</h5>
                <p class="text-10 mb-0">Member Since {{ date('M Y', strtotime($user->created_at)) }}</p>
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
                            class="sidebar__button {{ $pagename == 'travel-calendar' ? 'active -is-active text-blue-1' : '' }} col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('agent.travel-calendar') }}" class="icon text-center mr-15 text-24"><i
                                        class="fa fa-calendar"></i></a>
                                <a href="{{ route('agent.travel-calendar') }}">
                                    Travel Calender
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
                                <a href="{{ route('agent.booking-history', 'all') }}"
                                    class="icon text-center mr-15 text-24"><i class="fa fa-clock-o"></i></a>
                                <a href="{{ route('agent.booking-history', 'all') }}">
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
                                <a href="{{ route('agent.wishlist') }}" class="icon text-center mr-15 text-24"><i
                                        class="fa fa-heart-o"></i></a>
                                <a href="{{ route('agent.wishlist') }}">
                                    Wishlist
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar__item" data-position="81">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div class="sidebar__button  col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('agent.quotation') }}"
                                    class="icon text-center mr-15 text-24"><i class="icon ion-ios-pie"></i></a>
                                <a href="{{ route('agent.quotation') }}">
                                    My Quotation
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="sidebar__item" data-position="81">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div class="sidebar__button  col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('home') }}"
                                    class="icon text-center mr-15 text-24"><i class="icon ion-ios-pie"></i></a>
                                <a href="{{ route('home') }}">
                                    New Quotation
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="sidebar__item" data-position="90">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div class="sidebar__button  col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('agent.transaction', 'all') }}"
                                    class="icon text-center mr-15 text-24"><i class="icon ion-md-card"></i></a>
                                <a href="{{ route('agent.transaction', 'all') }}">
                                    Transaction
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar__item" data-position="95">
            <div class="accordion -db-sidebar js-accordion">
                <div class="accordion__item">
                    <div class="accordion__button">
                        <div class="sidebar__button  col-12 d-flex items-center justify-between">
                            <div class="d-flex items-center text-15 lh-1 fw-500">
                                <a href="{{ route('agent.my-profile') }}"
                                    class="icon text-center mr-15 text-24"><i class="fa fa-cogs"></i></a>
                                <a href="{{ route('agent.my-profile') }}">
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
                                <a href="{{ route('agent.my-change-password') }}"
                                    class="icon text-center mr-15 text-24"><i class="fa fa-lock"></i></a>
                                <a href="{{ route('agent.my-change-password') }}">
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