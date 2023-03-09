@extends('admin.layout.app')
@section('page_title', 'Add Offline Room')
@section('content')
    <section class="form-control-repeater">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Add Offline Room</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmOfflineRoom" class="room-repeater" method="post" enctype="multipart/form-data"
                            action="{{ route('offlinerooms.store') }}">
                            @csrf
                            @include('admin.offline-rooms.form')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('offlinerooms.index') }}">{{ __('core.back') }}</a>                                        
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
