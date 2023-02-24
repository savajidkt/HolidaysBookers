@extends('admin.layout.app')
@section('page_title', __('hotel-group/hotel-group.form_add_page_title'))
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('hotel-group/hotel-group.add_new') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmHotelGroup" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('hotelgroups.store') }}">
                            <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                            @csrf
                            @include('admin.hotel-group.form')
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('hotelgroups.index') }}">{{ __('core.back') }}</a>
                                    <button type="submit" id="user-save" class="btn btn-primary"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
