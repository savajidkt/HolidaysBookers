@extends('layouts.app')
@section('page_title', 'Forgot Password')
@section('content')

    <div class="header-margin"></div>
    <section class="layout-pt-lg layout-pb-lg bg-blue-2">
        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <form class="row g-3 needs-validation p-3" method="POST" action="{{ route('forgot-password') }}">
                        @csrf
                        <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                            <div class="row y-gap-20">
                                <div class="col-12">
                                    <h1 class="text-22 fw-500">{{ __('Reset Password') }}</h1>
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="{{ __('Email Address') }}">
                                        <label class="lh-1 text-14 text-light-1">{{ __('Email Address') }}</label>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback text-red-1" style="display: block;">{{ $message }}
                                        </div>
                                    @enderror
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
@endsection
