@extends('layouts.app')
@section('page_title', 'Login')
@section('content')



<!--<div class="header-margin"></div>-->

<section class="login-layout-page" style="background-image: url('{{ asset('/assets/img/loginimg.jpg') }}');background-position: center;background-repeat: no-repeat;background-size: cover;">

    <div class="sub-block-login">

        <div class="container">

            <div class="main-login-block">

                <div class="sub-from">

                    <form id="loginFrm" class="row g-3 needs-validation p-3" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="" style="background-color: #fff;padding: 5%;border-radius: 15px;backdrop-filter: blur(2px);">

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



                               <div class="col-12 text-center">

                                    @if(Auth::check())

                                        <img src="{{ asset('/assets/img/user-login-image.jpg') }}" alt="User Login Image" style="max-width: 200px;">

                                    @else

                                        <i class="fa fa-user" style="font-size: 100px;"></i>

                                    @endif

                                    <h1 class="login-text">Log In</h1>

                                    </div>
                                <div class="col-12">
                                    <div class="form-input emailDiv">

                                        <span class="fa fa-envelope" ></span>

                                        <input id="email" type="email" class="form-control" name="email"

                                            value="{{ old('email') }}" placeholder="&#xf0e0; Email*">

                                    </div>

                                </div>

                                <div class="col-12">
                                    <div class="form-input passwordDiv">

                                        <span class="fa fa-lock" ></span>

                                        <input id="password" type="password" class="form-control" name="password"

                                            placeholder="&#xf023; Password*">

                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></span>

                                    </div>

                                </div>
                                <div class="col-6">

                                    {{-- <div class="d-flex checkbox-login">

                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                        <label for="remember">Remember me</label>

                                    </div> --}}
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

                                    <p class="mt-10">Don't have an account yet? <a href="{{ route('register') }}"

                                            class="text-blue-1">Sign up for free</a></p>

                                </div>

                                <div class="col-12">

                                    <input class="button login-btn" type="submit" value="Sign In">

                                </div>
                          
                            </div>
                    
                        </div>
                    </form>

                </div>

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

<script>

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $($(this).attr("toggle"));

        if (input.attr("type") == "password") {

            input.attr("type", "text");

        } else {

            input.attr("type", "password");

        }

    });

</script>

@endsection
