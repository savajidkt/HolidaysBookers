@extends('layouts.app')
@section('page_title', 'Login')
@section('content')

    <div class="header-margin"></div>
    <section class="layout-pt-lg layout-pb-lg bg-blue-2">
        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-6 col-lg-7 col-md-9">

                    <form id="loginFrm" class="row g-3 needs-validation p-3" method="POST" action="{{ route('login') }}">
                        @csrf
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

                                <div class="col-12 " style="border-bottom: 1px dashed #ccc;">
                                    <h1 class="text-22 fw-500">Log In</h1>
                                </div>

                                <div class="col-12">
                                    <h4 class="form-title text-22 fw-500">Welcome back</h4>
                                    <p class="mt-10">Don't have an account yet? <a href="{{ route('register') }}"
                                            class="text-blue-1">Sign up for free</a></p>
                                </div>
                                <div class="col-12">
                                    <div class="form-input emailDiv">
                                        <input id="email" type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" placeholder="Email">
                                        <label class="lh-1 text-14 text-light-1">Email</label>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <div class="form-input passwordDiv">
                                        <input id="password" type="password" class="form-control" name="password"
                                            placeholder="Password">
                                        <label class="lh-1 text-14 text-light-1">Password</label>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="d-flex ">
                                        <div class="form-checkbox mt-5">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <div class="form-checkbox__mark">
                                                <div class="form-checkbox__icon icon-check"></div>
                                            </div>
                                        </div>
                                        <div class="text-15 lh-15 text-light-1 ml-10">Remember me</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    @if (Route::has('password.request'))
                                        <p class="small text-right"><a class="btn-link"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot Password?') }}
                                            </a></p>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <input class="button py-20 -dark-1 bg-blue-1 text-white" type="submit" value="Sign In">
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
