@extends('admin.layout.app')
@section('page_title','New Room Type')
@section('content')
<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Room Type</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation1" method="post" enctype="multipart/form-data" action="{{route('roomtypes.store')}}">
                        <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                        @csrf
                        @include('admin.room-types.form')
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-outline-secondary waves-effect" href="{{ route('roomtypes.index') }}">Back</a>                                                              
                                <button type="submit" id="user-save" class="btn btn-primary"><span
                                    class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                    aria-hidden="true"></span><span
                                    class="ml-25 align-middle">Submit</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection