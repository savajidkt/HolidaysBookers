@extends('admin.layout.app')
@section('page_title', 'Edit Room Price')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Edit Room Price</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmOfflineRoomPrice" class="room-repeater" novalidate method="post" enctype="multipart/form-data"
                            action="{{ route('edit-room-price', $pricemodel) }}">
                            @csrf                            
                            @include('admin.offline-rooms.offline-room-price.form')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary btn-sm waves-effect"
                                        href="{{ route('view-room-price', $model) }}">{{ __('core.back') }}</a>
                                    <button type="submit" id="user-save" class="btn btn-primary btn-sm"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            </div>
                        </form>
                        <div class="modal fade text-left" id="roomMealPlanBTN" tabindex="-1"
                    aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel120">Add Meal Plan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <form action="" method="post" id="FrmMealPlan"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="basic-addon-name">Meal
                                                        Plan</label>
                                                    <input type="text" id="basic-addon-name" name="name"
                                                        class="form-control" placeholder="Meal Plan" value=""
                                                        aria-describedby="basic-addon-name"
                                                        data-error="Meal plan name is required" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm waves-effect waves-float waves-light"><span
                                                        class="spinner-border spinner-border-sm buttonLoader hide"
                                                        role="status" aria-hidden="true"></span><span
                                                        class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
