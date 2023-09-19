@extends('layouts.app')
@section('page_title', 'Reset Password')
@section('content')

<main class="login-bg">
         <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
               <div class="container">
                  <div class="row justify-content-center">
                     <div class="col-md-9 col-md-12 d-flex flex-column align-items-center justify-content-center">
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="p-4">
                                       <form class="row g-1 needs-validation p-3" method="POST" action="{{ route('reset.password.post') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">
                                          <h1 class="card-title pt-0 pb-0 mb-0">{{ __('Reset Password') }}</h1>
                                          {{-- <div class="col-12">
                                             <div class="input-group has-validation">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email" require>

                                                @error('email')
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                             </div>
                                          </div> --}}
                                          <div></div>
                                          @error('password')
                                             <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $message }}</strong>
                                             </span>
                                          @enderror
                                          
                                          <label class="form-label" for="basic-addon-name">New Password <span class="text-danger">*</span></label>
                                          <div class="form-control col-12">
                                             <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required  placeholder="New Password">
                                          </div>
                                          <label class="form-label" for="basic-addon-name">Confirm Password <span class="text-danger">*</span></label>
                                          <div class="form-control col-12">
                                          <input id="password-confirm" type="password" class="" name="password_confirmation" required  placeholder="Confirm Password">
                                          </div>
                                          <div class="col-6">
                                             <button class="button -white bg-blue-1 px-30 fw-400  h-50 text-white " type="submit">{{ __('Reset Password') }}</button>
                                          </div>
                                          <div class="col-12">
                                             <div class="d-flex justify-content-center pt-3">
                                                <a href="{{ route('login') }}" class="logo d-flex align-items-center w-auto">
                                                <img src="{{asset('front/assets/img/logo.png')}}" alt="">
                                                </a>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                                 <div class="col-md-6 login-form-img"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </main>

@endsection
