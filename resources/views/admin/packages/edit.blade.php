@extends('admin.layout.app')
@section('page_title', 'Edit Package')
@section('content')
<script>
    var is_package = true;
</script>
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Edit Package</h4>
                    </div>
                    <div class="card-body">
                        <form class="package-repeater" id="FrmPackages" method="post" enctype="multipart/form-data"
                            action="{{ route('packages.update', $model) }}">
                            <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                            @csrf
                            @method('PUT')
                            @include('admin.packages.form')
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('packages.index') }}">{{ __('core.back') }}</a>
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
