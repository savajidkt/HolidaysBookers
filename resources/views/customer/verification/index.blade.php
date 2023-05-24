@extends('customer.layouts.app')
@section('page_title', 'WishList')
@section('content')
    <div class="dashboard__content bg-light-2 bravo_user_profile">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Verification Data</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>
        <div class="booking-history-manager">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="form-group">
                <div class="row align-items-center">
                    <label class="col-md-3 text-right col-form-label">Phone
                        :
                    </label>
                    <div class="col-md-4">
                        <div class=""><strong>{{ isset($user->usermeta->phone_number) ? $user->usermeta->phone_number : '' }}</strong></div>
                        @if (isset($user->usermeta->phone_status) && $user->usermeta->phone_status == 1)
                            <span class="badge badge-primary"><i>Verified</i></span>
                        @else
                            <span class="badge badge-secondary"><i>Not Verified</i></span>
                        @endif

                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
                <div class="row align-items-center">
                    <label class="col-md-3 text-right col-form-label">ID Card
                        <span class="text-danger">*</span>
                        :
                    </label>
                    <div class="col-md-4 btn-upload-private-wrap">
                        <div class="private-file-lists mb-2">
                        </div>
                        <div><strong>N/A</strong></div>
                        <span class="badge badge-secondary"><i>Not Verified</i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-3 text-right col-form-label">Trade License
                        <span class="text-danger">*</span>
                        :
                    </label>
                    <div class="col-md-4 btn-upload-private-wrap">
                        <div class="private-file-lists mb-2">
                        </div>
                        <div><strong>N/A</strong></div>
                        <span class="badge badge-secondary"><i>Not Verified</i></span>
                    </div>
                </div>
            </div> --}}
            <hr>
            @if ( isset($user->usermeta->phone_status) && $user->usermeta->phone_status == 0)
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <a href="{{ route('customer.verification-update', $user->id) }}" class="btn btn-warning"> <i
                                class="fa fa-edit"></i> Update verification data </a>
                    </div>
                </div>
            @endif
        </div>
        @include('customer.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
