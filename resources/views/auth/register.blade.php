@extends('layouts.app')
@section('page_title', 'Register')
@section('content')
    <div class="header-margin"></div>

    <section class="login-layout-page" style="background-image: url('{{ asset('/assets/img/loginimg.jpg') }}');background-position: center;background-repeat: no-repeat;background-size: cover;">

        <div class="sub-block-login">

        <div class="container">

                <div class="main-login-block">

                    <div class="sub-from">

                    <form id="RegisterFrm" class="row g-3 needs-validation p-3" method="POST" action="{{ route('register') }}">
                        @csrf

                            <div style="background-color: #fff;padding: 5%;border-radius: 15px;backdrop-filter: blur(2px);">

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

                                        <h1 class="login-text">Sign Up</h1>

                                </div>

                                    <div class="col-12 lift-right-reg">

                                    <h1 class="text-22 fw-500">Sign in or create an account</h1>

                                        <p>Already have an account? <a href="{{ route('login') }}" class="text-blue-1">Log in</a></p>

                                    </div>
                                <div class="col-12">
                                    <div class="form-input ferrorCls">

                                            <span class="fa fa-user"></span>

                                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" onkeydown="return /[a-z]/i.test(event.key)"  placeholder="First Name*">

                                    </div>
                                   
                                </div>
                                <div class="col-12">
                                    <div class="form-input lerrorCls">

                                            <span class="fa fa-user"></span>

                                            <input id="last_name" type="text" class="form-control " name="last_name" value="{{ old('last_name') }}" onkeydown="return /[a-z]/i.test(event.key)" placeholder="Last Name*">

                                    </div>
                                   
                                </div>
                                <div class="col-12">
                                    <div class="form-input eerrorCls">

                                            <span class="fa fa-envelope"></span>

                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email*">

                                    </div>
                                    
                                </div>
                                <input type="hidden" name="type" value="1">

                                <div class="col-12">
                                    <div class="form-input perrorCls">

                                            <span class="fa fa-lock"></span>

                                            <input id="password" type="password" class="form-control" name="password" placeholder="Password*">

                                    </div>
                                    
                                </div>
                                <div class="col-12">
                                    <div class="form-input pcerrorCls">

                                            <span class="fa fa-lock"></span>

                                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="Confirm Password*">

                                    </div>
                                </div>
                               
                                <div class="col-12">

                                        <button type="submit" class="button login-btn">

                                            <span class="icons">Sign Up</span>
                                            <div class="icon-arrow-top-right ml-15"></div>
                                            <div class="fa fa-spinner fa-spin ml-15" style="display: none;"></div>
                                        </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                </div>

            </div>
        </div>
    </section>

@endsection



@section('page-script')
    <script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('assets/front/js/login-register.js') }}"></script>
@endsection