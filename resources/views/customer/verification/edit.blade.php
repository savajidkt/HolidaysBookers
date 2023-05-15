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
            <form action="{{ route('customer.verification-update',$user->id) }}" method="POST">
                @csrf
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
                            <input type="text" class="form-control" name="verify_data_phone" value="">
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
                            <span class="btn btn-primary btn-sm "><i class="fa fa-upload"></i> Select File
                                <input class="btn-upload-private-file has-value" data-name="verify_data_id_card"
                                    data-multiple="" type="file">
                            </span>
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
                            <span class="btn btn-primary btn-sm "><i class="fa fa-upload"></i> Select Files
                                <input class="btn-upload-private-file has-value" multiple=""
                                    data-name="verify_data_trade_license[]" data-multiple="true" type="file">
                            </span>
                        </div>
                    </div>
                </div> --}}
                <hr>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <button class="btn btn-success"> <i class="fa fa-save"></i> Save changes </button>
                    </div>
                </div>
            </form>
        </div>
        @include('customer.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
