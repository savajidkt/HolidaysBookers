@extends('layouts.app')
@section('page_title', 'Contact Us')
@section('content')
    <div class="ratio ratio-16:9">
        <div class="map-ratio">
            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112136.11226056251!2d77.06815442966133!3d28.56214930914976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1b006d9cfa0f%3A0xfe799dbfd221a850!2sHolidays%20Bookers%20DMC!5e0!3m2!1sen!2sin!4v1681277336322!5m2!1sen!2sin"></iframe>
        </div>
    </div>

    <section>
        <div class="relative container">
            <div class="row justify-end">
                <div class="col-xl-5 col-lg-7">
                    <div class="map-form px-40 pt-40 pb-50 lg:px-30 lg:py-30 md:px-24 md:py-24 bg-white rounded-4 shadow-4">
                        <div class="text-22 fw-500">
                            Send a message
                        </div>
                        @if (Session::has('success'))
                            <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                                <div class="text-success-2 lh-1 fw-500">{{ Session::get('success') }}</div>
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                <div class="text-error-2 lh-1 fw-500">{{ Session::get('error') }}</div>
                            </div>
                        @endif
                        <form class="" id="ContactFrm" method="post" enctype="multipart/form-data"
                            action="{{ route('contact-us-submit') }}">
                            @csrf
                            <div class="row y-gap-20 pt-20">
                                <div class="col-12">
                                    <div class="form-input frmName">
                                        <input type="text" name="name" value="{{ old('name') }}" oninput="this.value = this.value.replace(/[^a-zA-Z]+/g, '').replace(/(\..*)\./g, '$1');">
                                        <label class="lh-1 text-16 text-light-1">Full Name <span class="text-danger">*</span></label>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="text-error-2">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="form-input frmEmail">
                                        <input type="email" name="email" value="{{ old('email') }}">
                                        <label class="lh-1 text-16 text-light-1">Email <span class="text-danger">*</span></label>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="text-error-2">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="form-input frmPhone">
                                        <input type="text" name="phone" value="{{ old('phone') }}" oninput="this.value = this.value.replace(/[^0-9]+/g, '').replace(/(\..*)\./g, '$1');">
                                        <label class="lh-1 text-16 text-light-1">Contact Number <span class="text-danger">*</span></label>
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="text-error-2">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="form-input frmMessage">
                                        <textarea name="message" rows="4">{{ old('message') }}</textarea>
                                        <label class="lh-1 text-16 text-light-1">Your Messages <span class="text-danger">*</span></label>
                                    </div>
                                    @if ($errors->has('message'))
                                        <span class="text-error-2">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="button px-24 h-50 -dark-1 bg-blue-1 text-white">
                                        Send a Messsage <div class="icon-arrow-top-right ml-15"></div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row x-gap-80 y-gap-20 justify-between">
                <div class="col-12">
                    <div class="text-30 sm:text-24 fw-600">Contact Us</div>
                </div>

                <div class="col-lg-3">
                    <div class="text-14 text-light-1">Address</div>
                    <div class="text-18 fw-500 mt-10">39A Ground Floor, Sarvodya School, Aya Nagar, New Delhi 110047</div>
                </div>

                <div class="col-auto">
                    <div class="text-14 text-light-1">Phone</div>
                    <div class="text-18 fw-500 mt-10">+9910560003</div>
                </div>

                <div class="col-auto">
                    <div class="text-14 text-light-1">Need live support?</div>
                    <div class="text-18 fw-500 mt-10">info@holidaysbookers.com</div>
                </div>

                <div class="col-auto">
                    <div class="text-14 text-light-1">Follow us on social media</div>
                    <div class="d-flex x-gap-20 items-center mt-10">
                        <a target="_blank" href="https://www.facebook.com/holidaysbookers"><i
                                class="icon-facebook text-14"></i></a>
                        <a target="_blank" href="https://twitter.com/Viveshkat"><i class="icon-twitter text-14"></i></a>
                        <a target="_blank" href="https://www.instagram.com/holidaysbookersdmc/"><i
                                class="icon-instagram text-14"></i></a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCi2tUiEPlCTIJvz_bJdbZLA"><i
                                class="icon-play text-14"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/Contact.js') }}"></script>
@endsection
