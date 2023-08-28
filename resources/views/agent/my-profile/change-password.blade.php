@extends('agent.layouts.app')
@section('page_title', 'Change Password')
@section('content')
    <div class="dashboard__content bg-light-2 bravo_user_profile">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Change Password</h1>
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
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button "><a
                                href="{{ route('agent.my-location') }}"
                                class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0">Location
                                Information</a></span>
                    </div>
                    <div class="col-auto">
                        <span
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button is-tab-el-active"
                            data-tab-target=".-tab-item-1">Change Password</span>
                    </div>
                </div>
                <div class="tabs__content pt-30 js-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active row">
                        <form id="change_password_form" action="{{ route('agent.my-change-password') }}" method="POST">
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
                                    <div class="col-md-12">
                                        <div class="form-input ferrorCls">
                                            <input type="password" name="old_password" class="has-value">
                                            <label class="lh-1 text-16 text-light-1">Old Password <span class="text-danger">*</span></label>
                                        </div>
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-input lerrorCls">
                                            <input type="password" name="new_password" id="new_password" class="has-value">
                                            <label class="lh-1 text-16 text-light-1">New Password <span class="text-danger">*</span></label>
                                        </div>
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-input eerrorCls">
                                            <input type="password" name="new_password_confirmation" class="has-value">
                                            <label class="lh-1 text-16 text-light-1">Confirm New Password <span class="text-danger">*</span></label>
                                        </div>
                                        @error('new_password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block pt-30">
                                <button class="button h-50 px-24 -dark-1 bg-blue-1 text-white" type="submit"><i
                                        class="fa fa-save mr-2 pr-10"></i> Change Password</button>
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
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/myprofile/change-password.js') }}"></script>
@endsection
