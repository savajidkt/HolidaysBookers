<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#"><span class="brand-logo"
                        style="display:none;">
                        <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                            <defs>
                                <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%"
                                    y2="89.4879456%">
                                    <stop stop-color="#000000" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                                <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%"
                                    y2="100%">
                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                </lineargradient>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                    <g id="Group" transform="translate(400.000000, 178.000000)">
                                        <path class="text-primary" id="Path"
                                            d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                            style="fill:currentColor"></path>
                                        <path id="Path1"
                                            d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                            fill="url(#linearGradient-1)" opacity="0.2"></path>
                                        <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                            points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                        </polygon>
                                        <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                            points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                        </polygon>
                                        <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                                            points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                    </g>
                                </g>
                            </g>
                        </svg></span>
                    <h2 class="brand-text"><img src="{{ asset('app-assets/images/logo/logo-inverse.png') }}">HB</h2>
                </a></li>

        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{ (Request::segment(2) == 'dashboard') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('admin/dashboard') }}">
                    <i data-feather='monitor'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span>
                </a>
            </li>

            <li class=" nav-item {{ (Request::segment(2) == 'customers') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('admin/customers') }}">
                    <i data-feather='users'></i>
                    <span class="menu-title text-truncate" data-i18n="Customers">Customers</span>
                </a>
            </li>
            <li class=" nav-item {{ (Request::segment(2) == 'agents') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('admin/agents') }}">
                    <i data-feather='user'></i>
                    <span class="menu-title text-truncate" data-i18n="Agents">Agents Management</span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='user'></i>
                    <span class="menu-title text-truncate" data-i18n="Vendors">Vendors Management</span>
                </a>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='user'></i>
                    <span class="menu-title text-truncate" data-i18n="Corporate Management">Corporate Management</span>
                </a>
            </li>
            @if (
                $admin->can('admin-staff-create') ||
                    $admin->can('admin-staff-edit') ||
                    $admin->can('admin-staff-delete') ||
                    $admin->can('admin-staff-view'))
                <li class=" nav-item  {{ (Request::segment(2) == 'admins') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ url('admin/admins') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate"
                            data-i18n="Staff Management">Staff Management</span>
                    </a>

                </li>
            @endif
            <li class="navigation-header"><span
                    data-i18n="{{ __('core.menu_header_hotels') }}">{{ __('core.menu_header_hotels') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#">
                    <i data-feather='home'></i><span class="menu-title text-truncate"
                        data-i18n="{{ __('core.dropdown_manu_header_title_hotels') }}">{{ __('core.dropdown_manu_header_title_hotels') }}</span></a>
                <ul class="menu-content">
                    @if (
                        $admin->can('offline-hotels-create') ||
                            $admin->can('offline-hotels-edit') ||
                            $admin->can('offline-hotels-delete') ||
                            $admin->can('offline-hotels-view'))
                        <li class=" {{ (Request::segment(2) == 'offlinehotels') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ url('admin/offlinehotels') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="Offline">Offline</span>
                            </a>
                        </li>
                    @endif
                    @if (
                        $admin->can('api-hotels-create') ||
                            $admin->can('api-hotels-edit') ||
                            $admin->can('api-hotels-delete') ||
                            $admin->can('api-hotels-view'))
                        <li class=" {{ (Request::segment(2) == 'apihotels') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ url('admin/apihotels') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="API Hotels">API Hotels</span>
                            </a>
                        </li>
                    @endif
                    @if (
                        $admin->can('hotel-groups-create') ||
                            $admin->can('hotel-groups-edit') ||
                            $admin->can('hotel-groups-delete') ||
                            $admin->can('hotel-groups-view'))
                        <li class=" {{ (Request::segment(2) == 'hotelgroups') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/hotelgroups') }}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate"
                                    data-i18n="{{ __('hotel-group/hotel-group.menu') }}">{{ __('hotel-group/hotel-group.menu') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (
                        $admin->can('property-types-create') ||
                            $admin->can('property-types-edit') ||
                            $admin->can('property-types-delete') ||
                            $admin->can('property-types-view'))
                        <li class=" {{ (Request::segment(2) == 'propertytypes') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ url('admin/propertytypes') }}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate"
                                    data-i18n="{{ __('propertytype/propertytype.menu') }}">{{ __('propertytype/propertytype.menu') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (
                        $admin->can('room-types-create') ||
                            $admin->can('room-types-edit') ||
                            $admin->can('room-types-delete') ||
                            $admin->can('room-types-view'))
                        <li class=" {{ (Request::segment(2) == 'roomtypes') ? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ url('admin/roomtypes') }}">
                                <i data-feather='circle'></i>
                                <span class="menu-title text-truncate"
                                    data-i18n="{{ __('roomtype/roomtype.menu') }}">{{ __('roomtype/roomtype.menu') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (
                        $admin->can('amenities-create') ||
                            $admin->can('amenities-edit') ||
                            $admin->can('amenities-delete') ||
                            $admin->can('amenities-view'))
                        <li class=" {{ (Request::segment(2) == 'amenities') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/amenities') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('amenity/amenity.menu') }}">{{ __('amenity/amenity.menu') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (
                        $admin->can('freebies-create') ||
                            $admin->can('freebies-edit') ||
                            $admin->can('freebies-delete') ||
                            $admin->can('freebies-view'))
                        <li class=" {{ (Request::segment(2) == 'freebies') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/freebies') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="Freebies">Freebies</span>
                            </a>
                        </li>
                    @endif

                    {{-- @if (
                        $admin->can('hotel-facility-create') ||
                            $admin->can('hotel-facility-edit') ||
                            $admin->can('hotel-facility-delete') ||
                            $admin->can('hotel-facility-view')) --}}
                        <li class=" {{ (Request::segment(2) == 'hotelfacility') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/hotelfacility') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="Hotel Facility">Hotel Facility</span>
                            </a>
                        </li>  
                        
                        <li class=" {{ (Request::segment(2) == 'stayrequest') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/stayrequest') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="Stay Request">Stay Request</span>
                            </a>
                        </li>  
                    {{-- @endif --}}

                    @if (
                        $admin->can('vehicle-type-create') ||
                            $admin->can('vehicle-type-edit') ||
                            $admin->can('vehicle-type-delete') ||
                            $admin->can('vehicle-type-view'))
                        <li class=" {{ (Request::segment(2) == 'vehicletypes') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/vehicletypes') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('vehicletype/vehicletype.menu') }}">{{ __('vehicletype/vehicletype.menu') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            @if (
                $admin->can('rooms-create') ||
                    $admin->can('rooms-edit') ||
                    $admin->can('rooms-delete') ||
                    $admin->can('rooms-view'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="#">
                        <i data-feather='map'></i><span class="menu-title text-truncate"
                            data-i18n="Rooms">Rooms</span></a>
                    <ul class="menu-content">
                        <li class=" {{ (Request::segment(2) == 'offlinerooms') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/offlinerooms') }}">
                                <i data-feather='map-pin'></i><span class="menu-item text-truncate"
                                    data-i18n="Offline Rooms">Offline Rooms</span>
                            </a>
                        </li>
                        @if (
                            $admin->can('meal-plan-create') ||
                                $admin->can('meal-plan-edit') ||
                                $admin->can('meal-plan-delete') ||
                                $admin->can('meal-plan-view'))
                            <li class=" nav-item  {{ (Request::segment(2) == 'mealplans') ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ url('admin/mealplans') }}">
                                    <i data-feather='columns'></i>
                                    <span class="menu-title text-truncate" data-i18n="Meal Plans">Meal Plans</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif


            <li class="navigation-header"><span data-i18n="Order Management">Order Management</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#">
                    <i data-feather='map'></i><span class="menu-title text-truncate"
                        data-i18n="Order">Order</span></a>
                <ul class="menu-content">
                    <li class=" {{ (Request::segment(2) == 'orders') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ url('admin/orders') }}">
                            <i data-feather='circle'></i><span class="menu-item text-truncate"
                                data-i18n="Hotel Orders">Hotel Orders</span>
                        </a>
                    </li>
                </ul>
            </li>



            <li class="navigation-header"><span data-i18n="Package Module">Package Module</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item {{ (Request::segment(2) == 'packages') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('admin/packages') }}">
                    <i data-feather='package'></i>
                    <span class="menu-title text-truncate" data-i18n="Rooms">Package Management</span>
                </a>
            </li>

            <li class="navigation-header"><span
                    data-i18n="Master Modules">{{ __('core.menu_header_master_modules') }}</span><i
                    data-feather="more-horizontal"></i>
            </li>
            @if (
                $admin->can('location-create') ||
                    $admin->can('location-edit') ||
                    $admin->can('location-delete') ||
                    $admin->can('location-view'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="#">
                        <i data-feather='map'></i><span class="menu-title text-truncate"
                            data-i18n="{{ __('core.dropdown_manu_header_title_location') }}">{{ __('core.dropdown_manu_header_title_location') }}</span></a>
                    <ul class="menu-content">
                        <li class=" {{ (Request::segment(2) == 'countries') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/countries') }}">
                                <i data-feather='map-pin'></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('country/country.menu') }}">{{ __('country/country.menu') }}</span>
                            </a>
                        </li>
                        <li class=" {{ (Request::segment(2) == 'states') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/states') }}">
                                <i data-feather='map-pin'></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('state/state.menu') }}">{{ __('state/state.menu') }}</span>
                            </a>
                        </li>
                        <li class=" {{ (Request::segment(2) == 'cities') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/cities') }}">
                                <i data-feather='map-pin'></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('city/city.menu') }}">{{ __('city/city.menu') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if ($admin->can('api-create') || $admin->can('api-edit') || $admin->can('api-delete') || $admin->can('api-view'))
                <li class=" nav-item {{ (Request::segment(2) == 'apis') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ url('admin/apis') }}">
                        <i data-feather='cloud'></i>
                        <span class="menu-title text-truncate"
                            data-i18n="{{ __('api/api.menu') }}">{{ __('api/api.menu') }}</span>
                    </a>
                </li>
            @endif
            @if (
                $admin->can('company-type-create') ||
                    $admin->can('company-type-edit') ||
                    $admin->can('company-type-delete') ||
                    $admin->can('company-type-view'))
                <li class=" nav-item {{ (Request::segment(2) == 'companytypes') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ url('admin/companytypes') }}">
                        <i data-feather='columns'></i>
                        <span class="menu-title text-truncate"
                            data-i18n="{{ __('company-type/company-type.menu') }}">{{ __('company-type/company-type.menu') }}</span>
                    </a>
                </li>
            @endif
            @if (
                $admin->can('reach-us-create') ||
                    $admin->can('reach-us-edit') ||
                    $admin->can('reach-us-delete') ||
                    $admin->can('reach-us-view'))
                <li class=" nav-item {{ (Request::segment(2) == 'reachus') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ url('admin/reachus') }}">
                        <i data-feather='columns'></i>
                        <span class="menu-title text-truncate"
                            data-i18n="{{ __('reach-us/reach-us.menu') }}">{{ __('reach-us/reach-us.menu') }}</span>
                    </a>
                </li>
            @endif

            @if (
                $admin->can('currency-create') ||
                    $admin->can('currency-edit') ||
                    $admin->can('currency-delete') ||
                    $admin->can('currency-view'))
                <li class=" nav-item {{ (Request::segment(2) == 'currencies') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ url('admin/currencies') }}">
                        <i data-feather='columns'></i>
                        <span class="menu-title text-truncate" data-i18n="Currencies">Currencies</span>
                    </a>
                </li>
            @endif

            <li class=" nav-item"><a class="d-flex align-items-center" href="#">
                    <i data-feather='map'></i><span class="menu-title text-truncate"
                        data-i18n="{{ __('core.dropdown_manu_header_title_location') }}">{{ __('core.menu_header_markup_modules') }}</span></a>
                <ul class="menu-content">
                    @if (
                        $admin->can('product-markup-create') ||
                            $admin->can('product-markup-edit') ||
                            $admin->can('product-markup-delete') ||
                            $admin->can('product-markup-view'))
                        <li class=" {{ (Request::segment(2) == 'productmarkups') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/productmarkups') }}">
                                <i data-feather='map-pin'></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('product-markup/product-markup.menu') }}">{{ __('product-markup/product-markup.menu') }}</span>
                            </a>
                        </li>
                    @endif
                    @if (
                        $admin->can('agent-markup-create') ||
                            $admin->can('agent-markup-edit') ||
                            $admin->can('agent-markup-delete') ||
                            $admin->can('agent-markup-view'))
                        <li class=" {{ (Request::segment(2) == 'agentmarkups') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ url('admin/agentmarkups') }}">
                                <i data-feather='map-pin'></i><span class="menu-item text-truncate"
                                    data-i18n="{{ __('agent-markup/agent-markup.menu') }}">{{ __('agent-markup/agent-markup.menu') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @if ($admin->can('role-create') || $admin->can('role-edit') || $admin->can('role-delete') || $admin->can('role-view'))
                <li class=" nav-item {{ (Request::segment(2) == 'roles') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ url('admin/roles') }}">
                        <i data-feather='life-buoy'></i><span class="menu-title text-truncate"
                            data-i18n="Admins">Roles</span>
                    </a>

                </li>
            @endif
            <li class=" nav-item {{ (Request::segment(2) == 'permissions') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('admin/permissions') }}">
                    <i data-feather='unlock'></i><span class="menu-title text-truncate"
                        data-i18n="Permissions">Permissions</span>
                </a>

            </li>
           
            <li class=" nav-item"><a class="d-flex align-items-center" href="#">
                <i data-feather='settings'></i><span class="menu-title text-truncate"
                    data-i18n="settings">Settings</span></a>
            <ul class="menu-content">
                <li class=" {{ (Request::segment(2) == 'settings') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="{{ route('settings.index') }}">
                        <i data-feather='settings'></i><span class="menu-item text-truncate"
                            data-i18n="Email Settings">Email Settings</span>
                    </a>
                </li>
                
                <li class=" {{ (Request::segment(2) == 'agent-global-markup') ? 'active' : '' }} ">
                    <a class="d-flex align-items-center" href="{{ route('setting-global-markup') }}">
                        <i data-feather='settings'></i><span class="menu-item text-truncate"
                            data-i18n="Email Settings">Global Markup</span>
                    </a>
                </li>

                <li class=" {{ (Request::segment(2) == 'hb-email-settings') ? 'active' : '' }} ">
                    <a class="d-flex align-items-center" href="{{ route('setting-hb-email') }}">
                        <i data-feather='settings'></i><span class="menu-item text-truncate"
                            data-i18n="HB Emails">HB Emails</span>
                    </a>
                </li>

            </ul>
        </li>
        </ul>
    </div>
</div>
