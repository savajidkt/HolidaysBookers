@extends('agent.layouts.app')
@section('page_title', 'My Location')
@section('content')
    <div class="dashboard__content bg-light-2 bravo_user_profile">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">My Location</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3">
            <div class="tabs -underline-2 js-tabs">
                <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                    <div class="col-auto">
                        <span
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button "><a
                                href="{{ route('agent.my-profile') }}"
                                class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0">Personal
                                Information</a></span>
                    </div>
                    <div class="col-auto">
                        <span
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button is-tab-el-active"
                            data-tab-target=".-tab-item-1">Location
                            Information</span>
                    </div>
                    <div class="col-auto">
                        <span
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button "><a
                                href="{{ route('agent.my-change-password') }}"
                                class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0">Change
                                Password</a></span>
                    </div>
                </div>
                <div class="tabs__content pt-30 js-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active row">
                        <form id="location_information" action="{{ route('agent.my-location') }}" method="post">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="col-xl-9">
                                <div class="row x-gap-20 y-gap-20">
                                    <div class="col-12">
                                        <div class="form-input ferrorCls">
                                            <input type="text" value="{{ isset($user->userMeta->address_1) ? $user->userMeta->address_1 : '' }}" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');" name="address">
                                            <label class="lh-1 text-16 text-light-1">Address Line 1 <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-input lerrorCls">
                                            <input type="text" value="{{ isset($user->userMeta->address_2) ? $user->userMeta->address_2 : '' }}" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');" name="address2">
                                            <label class="lh-1 text-16 text-light-1">Address Line 2 <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input eerrorCls">
                                            <input type="text" value="{{ isset($user->userMeta->city) ? $user->userMeta->city : '' }}" onkeydown="return /[a-z]/i.test(event.key)" name="city">
                                            <label class="lh-1 text-16 text-light-1">City <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input stateCls">
                                            <input type="text" value="{{ isset($user->userMeta->state) ? $user->userMeta->state : '' }}" onkeydown="return /[a-z]/i.test(event.key)" name="state">
                                            <label class="lh-1 text-16 text-light-1">State <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input countryCls">
                                            <select name="country" class="form-control select2">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ isset($user->userMeta->country_id) && $user->userMeta->country_id == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            {{-- <label class="lh-1 text-16 text-light-1">Select Country</label> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input zipcodeCls">
                                            <input type="text" value="{{ isset($user->userMeta->zip) ? $user->userMeta->zip : '' }}" oninput="this.value = this.value.replace(/[^0-9a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');" name="zip_code">
                                            <label class="lh-1 text-16 text-light-1">ZIP Code <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block pt-30">
                                <button class="button h-50 px-24 -dark-1 bg-blue-1 text-white" type="submit"><i
                                        class="fa fa-save mr-2 pr-10"></i> Save Changes</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('agent.common.footer')
    </div>
@endsection
@section('page-script')
    <script>
        $('.select2').select2();
    </script>
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/myprofile/location-information.js') }}"></script>
@endsection
