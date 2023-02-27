@extends('admin.layout.app')
@section('page_title', __('product-markup/product-markup.form_edit_title'))
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('product-markup/product-markup.form_edit_title') }}</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmProductMarkup" class="needs-validation1" novalidate method="post"
                            enctype="multipart/form-data" action="{{ route('productmarkups.update', $model) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.product-markups.form')
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('productmarkups.index') }}">{{ __('core.back') }}</a>
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
