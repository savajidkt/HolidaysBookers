@extends('admin.layout.app')
@section('page_title', __('amenity/amenity.form_edit_title'))
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('amenity/amenity.form_edit_title') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="jquery-val-form" class="needs-validation1" novalidate method="post"
                            enctype="multipart/form-data" action="{{ route('amenities.update', $model) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.amenities.form')
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('amenities.index') }}">{{ __('core.back') }}</a>
                                    <button type="submit" id="user-save" class="btn btn-primary"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
