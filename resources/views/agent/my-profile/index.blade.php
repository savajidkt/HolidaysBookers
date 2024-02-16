@extends('agent.layouts.app')
@section('page_title', 'My Profile')
@section('content')
    <div class="dashboard__content bg-light-2 bravo_user_profile">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">My Profile</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3">
            <div class="tabs">
                <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                    <div class="col-auto">
                        <span
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button is-tab-el-active"
                            data-tab-target=".-tab-item-1">Personal Information</span>
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
                            class="tabs__button cursor-pointer text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 js-tabs-button "><a
                                href="{{ route('agent.my-change-password') }}"
                                class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0">Change
                                Password</a></span>
                    </div>
                </div>
                <div class="tabs__content pt-30 js-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active row">
                        <form id="personal_information" action="{{ route('agent.my-profile') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="row y-gap-30 items-center upload-btn-wrapper">
                                <div class="col-auto">
                                    <div class="d-flex ratio ratio-1:1 w-200">
                                        
                                        <img class="image-demo img-ratio rounded-4"
                                            src="{{ isset($user->userMeta->user_avatar) && strlen($user->userMeta->user_avatar) > 0 ? url(Storage::url('app/upload/avatar/' . $user->id . '/' . $user->usermeta->user_avatar)) : 'https://gotrip.bookingcore.org/images/avatar.png' }}">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <h4 class="text-16 fw-500">Your avatar</h4>
                                    <div class="text-14 mt-5">PNG or JPG.</div>
                                    <div class="d-inline-block mt-15">
                                        <button type="button" class="button h-50 px-24 -dark-1 bg-blue-1 text-white btn-file">
                                            <input type="file" class="has-value" name="user_avatar" accept="image/png,image/jpeg">
                                        </button>
                                    </div>                                                                       
                                </div>
                            </div>
                            <div class="border-top-light mt-30 mb-30"></div>
                            <div class="col-xl-9">
                                <div class="row x-gap-20 y-gap-20">                                    
                                    <div class="col-md-6">
                                        <div class="form-input ferrorCls">
                                            <input type="text" value="{{ $user->first_name }}" onkeydown="return /[a-z]/i.test(event.key)" name="first_name" class="has-value">
                                            <label class="lh-1 text-16 text-light-1">First Name <span class="text-danger">*</span></label>
                                        </div>
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input lerrorCls">
                                            <input type="text" value="{{ $user->last_name }}" onkeydown="return /[a-z]/i.test(event.key)" name="last_name" class="has-value">
                                            <label class="lh-1 text-16 text-light-1">Last Name <span class="text-danger">*</span></label>
                                        </div>
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input eerrorCls">
                                            <input type="text" name="email" value="{{ $user->email }}" class="has-value" disabled>
                                            <label class="lh-1 text-16 text-light-1">Email <span class="text-danger">*</span></label>
                                        </div>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input phoneCls">
                                            <input type="text" value="{{ isset($user->userMeta->phone_number) ? $user->userMeta->phone_number : '' }}" oninput="this.value = this.value.replace(/[^0-9]+/g, '').replace(/(\..*)\./g, '$1');" name="phone_number" class="has-value">
                                            <label class="lh-1 text-16 text-light-1">Phone Number <span class="text-danger">*</span></label>
                                        </div>
                                        @error('phone_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/myprofile/personal-information.js') }}"></script>
@endsection
