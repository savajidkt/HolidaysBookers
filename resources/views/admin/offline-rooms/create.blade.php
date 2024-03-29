@extends('admin.layout.app')
@section('page_title', 'Add Offline Room')
@section('content')
    <div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">
        <div class="col-md-6">
            <a class="btn btn-outline-secondary waves-effect"
                href="{{ route('hotel-room-list', $offlinehotel->id) }}">Back</a>
        </div>
        
    </div>
    <section class="form-control-repeater">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Add New Room</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmOfflineRoom" class="room-repeater" method="post" enctype="multipart/form-data"
                            action="{{ route('offlinerooms.store') }}">
                            @csrf
                            @include('admin.offline-rooms.form')
                            <div class="row mt-3">
                                <div class="col-12">

                                    <button type="submit" id="user-save" class="btn btn-primary btn-sm"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                </div>
                            </div>
                        </form>
                        <div class="modal fade text-left" id="roomTypeBTN" tabindex="-1" aria-labelledby="myModalLabel120"
                            aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Add Room Type</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="FrmroomType"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                for="basic-addon-room_type">{{ __('roomtype/roomtype.form_room_type') }}
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" id="basic-addon-room_type"
                                                                name="room_type" class="form-control"
                                                                onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                                placeholder="{{ __('roomtype/roomtype.form_room_type') }}"
                                                                value="" aria-describedby="basic-addon-room_type"
                                                                data-error="{{ __('roomtype/message.room_type_required') }}" />
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
                        <div class="modal fade text-left" id="roomAmenityBTN" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Add Amenity</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="FrmroomAmenity"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="basic-addon-amenity_name">Amenity
                                                                Name <span class="text-danger">*</span></label>
                                                            <input type="text" id="basic-addon-amenity_name"
                                                                name="amenity_name" class="form-control"
                                                                onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                                placeholder="Amenity Name" value=""
                                                                aria-describedby="basic-addon-amenity_name"
                                                                data-error="Amenity name is required." />

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
                        <div class="modal fade text-left" id="roomFreebiesBTN" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Add Freebies</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="FrmFreebies"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="basic-addon-name">Freebies
                                                                Name <span class="text-danger">*</span></label>
                                                            <input type="text" id="basic-addon-name" name="name"
                                                                onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                                class="form-control" placeholder="Freebies Name"
                                                                value="" aria-describedby="basic-addon-name"
                                                                data-error="Freebies name is required." />

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