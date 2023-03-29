@extends('admin.layout.app')
@section('page_title', 'Add Package')
@section('content')

    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Add Package</h4>
                    </div>
                    <div class="card-body">
                        <form class="package-repeater" id="FrmPackages" method="post" enctype="multipart/form-data"
                            action="{{ route('packages.store') }}">
                            @csrf
                            @include('admin.packages.form')
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-12">
                                        <a class="btn btn-outline-secondary waves-effect"
                                            href="{{ route('packages.index') }}">{{ __('core.back') }}</a>
                                        <button type="submit" id="user-save" class="btn btn-primary"><span
                                                class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                                aria-hidden="true"></span><span
                                                class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection