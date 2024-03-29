@extends('customer.layouts.app')
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
                                href="{{ route('customer.my-profile') }}"
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
                                href="{{ route('customer.my-change-password') }}"
                                class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0">Change
                                Password</a></span>
                    </div>
                </div>
                <div class="tabs__content pt-30 js-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active row">
                        <form action="" method="post">
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
                                        <div class="form-input ">
                                            <input type="text" value="{{ $user->userMeta->address_1 }}" name="address">
                                            <label class="lh-1 text-16 text-light-1">Address Line 1</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-input ">
                                            <input type="text" value="{{ $user->userMeta->address_2 }}" name="address2">
                                            <label class="lh-1 text-16 text-light-1">Address Line 2</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input ">
                                            <input type="text" value="{{ $user->userMeta->city }}" name="city">
                                            <label class="lh-1 text-16 text-light-1">City</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input ">
                                            <input type="text" value="{{ $user->userMeta->state }}" name="state">
                                            <label class="lh-1 text-16 text-light-1">State</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input ">
                                            <select name="country" class="form-control">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $user->userMeta->country_id == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <label class="lh-1 text-16 text-light-1">Select Country</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input ">
                                            <input type="text" value="{{ $user->userMeta->zip }}" name="zip_code">
                                            <label class="lh-1 text-16 text-light-1">ZIP Code</label>
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
        @include('customer.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
