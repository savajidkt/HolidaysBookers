@extends('layouts.app')
@section('page_title', 'Forgot Password')
@section('content')

    <div class="header-margin"></div>
    <section class="layout-pt-lg layout-pb-lg bg-blue-2">
        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <form id="ForgotFrm" class="row g-3 needs-validation p-3" method="POST" action="{{ route('forgot-password') }}">
                        @csrf
                        @if (session('status'))
                            <div class="col-12">
                                <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                                    <div class="text-success-2 lh-1 fw-500">{{ session('status') }}</div>                                    
                                </div>
                            </div>
                        @endif
                        <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                            <div class="row y-gap-20">
                                <div class="col-12">
                                    @if (count($errors) > 0)
                                        @foreach ($errors->all() as $message)
                                            <div class="alert alert-danger display-hide">
                                                <button class="close" data-close="alert"></button>
                                                <span>{{ $message }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-12">
                                    <h1 class="text-22 fw-500">{{ __('Reset Password') }}</h1>
                                </div>
                                <div class="col-12">
                                    <div class="form-input emailDiv">
                                        <input id="email" type="email"
                                            class="form-control" name="email"
                                            value="{{ old('email') }}" placeholder="{{ __('Email Address') }}">
                                        <label class="lh-1 text-14 text-light-1">{{ __('Email Address') }}</label>
                                    </div>
                                   
                                </div>
                                <div class="col-12">
                                    <p class="small text-right"><a class="btn-link" href="{{ route('login') }}">
                                            {{ __('Login') }}
                                        </a></p>
                                </div>
                                <div class="col-12">
                                    <input class="button py-20 -dark-1 bg-blue-1 text-white" type="submit"
                                        value="{{ __('Send Password Reset Link') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @section('page-script')
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/front/js/sweet-alert.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/front/js/sweetalert2.all.min.js') }}"></script> --}}
    <script src="{{ asset('assets/front/js/login-register.js') }}"></script>
@endsection
