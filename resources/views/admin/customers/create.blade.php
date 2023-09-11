@extends('admin.layout.app')
@section('page_title', 'New Customer')
@section('content')
<style>
    .form-group.train-deet[data-select2-id] >.input-error {
  display: flex;
  flex-direction: column-reverse;
}
.input-error .help-block-error {
    order: -1;
}
</style>
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">New Customer</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmCustomer" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('customers.store') }}">
                            @csrf
                            @include('admin.customers.form')
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('customers.index') }}">{{ __('core.back') }}</a>
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
