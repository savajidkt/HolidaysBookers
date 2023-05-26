@extends('layouts.app')
@section('page_title', 'Register')
@section('content')
    <div class="header-margin"></div>
    <section class="layout-pt-lg layout-pb-lg bg-blue-2">
        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <form class="row g-3 needs-validation p-3" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                            <div class="row y-gap-20">
                                <div class="col-12" style="border-bottom: 1px dashed #ccc;">
                                    <h1 class="text-22 fw-500">Sign Up</h1>
                                </div>
                                <div class="col-12">
                                    <h1 class="text-22 fw-500">Sign in or create an account</h1>
                                    <p class="mt-10">Already have an account? <a  href="{{ route('login') }}" class="text-blue-1">Log in</a></p>
                                    </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="first_name" type="text"
                                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                            value="{{ old('first_name') }}">
                                        <label class="lh-1 text-14 text-light-1">First Name</label>
                                    </div>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="last_name" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                            value="{{ old('last_name') }}">
                                        <label class="lh-1 text-14 text-light-1">Last Name</label>
                                    </div>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}">
                                        <label class="lh-1 text-14 text-light-1">Email</label>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <input type="hidden" name="type" value="1">
                                {{-- <div class="col-4">
                                    <div class="form-radio d-flex items-center ">
                                        <div class="radio">
                                            <input type="radio" name="type" value="1">
                                            <div class="radio__mark">
                                                <div class="radio__icon"></div>
                                            </div>
                                        </div>
                                        <div class="text-14 lh-1 ml-10">Agent</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-radio d-flex items-center ">
                                        <div class="radio">
                                            <input type="radio" name="type" value="2">
                                            <div class="radio__mark">
                                                <div class="radio__icon"></div>
                                            </div>
                                        </div>
                                        <div class="text-14 lh-1 ml-10">Customer</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-radio d-flex items-center ">
                                        <div class="radio">
                                            <input type="radio" name="type" value="4">
                                            <div class="radio__mark">
                                                <div class="radio__icon"></div>
                                            </div>
                                        </div>
                                        <div class="text-14 lh-1 ml-10">Corporate</div>
                                    </div>
                                </div>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror --}}
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password">
                                        <label class="lh-1 text-14 text-light-1">Password</label>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input type="password" name="password_confirmation" id="password-confirm">
                                        <label class="lh-1 text-14 text-light-1">{{ __('Confirm Password') }}</label>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    {{-- <input class="button py-20 -dark-1 bg-blue-1 text-white" type="submit"
                                        value="{{ __('Register') }}"> --}}
                                        <button type="submit" class="button py-20 -dark-1 bg-blue-1 text-white w-100">
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
    </section>

@endsection
