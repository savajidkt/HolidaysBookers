@extends('admin.layout.app')
@section('page_title', 'Edit Orders')
@section('content')
<div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">
    <div class="col-md-6">
        <a class="btn btn-outline-secondary waves-effect" href="{{ route('orders.show', $model->id) }}">Back</a>
    </div>    
</div>
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Edit Orders</h4>
                    </div>
                    <div class="card-body">
                        <form class="" id="FrmOrders" method="post" enctype="multipart/form-data"
                            action="{{ route('orders.update', $model) }}">
                            <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                            <input type="hidden" name="action" value="order">
                            @csrf
                            @method('PUT')
                            @include('admin.order.form')
                            <div class="row">
                                <div class="col-12">                                   
                                    <button type="submit" id="user-save" class="btn btn-primary"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <form class="" id="FrmOrdersPassenger" method="post" enctype="multipart/form-data"
                            action="{{ route('orders.update', $model) }}">
                            <input type="hidden" name="action" value="passenger">
                            <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                            @csrf
                            @method('PUT')
                            @include('admin.order.passengerform')
                            <div class="row">
                                <div class="col-12">                                   
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
