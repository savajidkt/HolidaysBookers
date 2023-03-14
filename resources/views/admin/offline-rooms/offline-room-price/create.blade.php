@extends('admin.layout.app')
@section('page_title', 'Add Room Price')
@section('content')
    <section class="form-control-repeater">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Add Room Price</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmOfflineRoomPrice" class="room-repeater" method="post" enctype="multipart/form-data"
                            action="{{ route('add-room-price', $model) }}">
                            @csrf
                            @include('admin.offline-rooms.offline-room-price.form')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('view-room-price', $model) }}">{{ __('core.back') }}</a>
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