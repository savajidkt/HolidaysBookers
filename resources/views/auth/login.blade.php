@extends('layouts.app')
@section('page_title', 'Login')
@section('content')

    <div class="header-margin"></div>
    <section class="layout-pt-lg layout-pb-lg bg-blue-2">
        <div class="container">
            <div class="row justify-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <form class="row g-3 needs-validation p-3" method="POST" action="{{ route('login') }}">
                        @csrf


                        <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                            <div class="row y-gap-20">
                                <div class="col-12">
                                    <h1 class="text-22 fw-500">Sign in</h1>
                                    <p class="mt-10">No account? <a href="{{ route('register') }}"
                                            class="text-blue-1">Create
                                            account here.</a>
                                    </p>
                                </div>
                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="Email">
                                        <label class="lh-1 text-14 text-light-1">Email</label>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback text-red-1" style="display: block;">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-input ">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Password">
                                        <label class="lh-1 text-14 text-light-1">Password</label>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback text-red-1" style="display: block;">{{ $message }}
                                        </div>
                                    @enderror
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

                            {{-- <div class="row y-gap-20 pt-30">
                            <div class="col-12">
                                <div class="text-center">or sign in with</div>
                                <button class="button col-12 -outline-blue-1 text-blue-1 py-15 rounded-8 mt-10">
                                    <i class="icon-apple text-15 mr-10"></i>
                                    Facebook
                                </button>
                                <button class="button col-12 -outline-red-1 text-red-1 py-15 rounded-8 mt-15">
                                    <i class="icon-apple text-15 mr-10"></i>
                                    Google
                                </button>
                                <button class="button col-12 -outline-dark-2 text-dark-2 py-15 rounded-8 mt-15">
                                    <i class="icon-apple text-15 mr-10"></i>
                                    Apple
                                </button>
                            </div>
                            <div class="col-12">
                                <div class="text-center px-30">By signing in, I agree to GoTrip Terms of Use and Privacy
                                    Policy.</div>
                            </div>
                        </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
