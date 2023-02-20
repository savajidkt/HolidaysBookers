@extends('admin.layout.app')
@section('page_title','New Property Type')
@section('content')
<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Property Type</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation1" method="post" enctype="multipart/form-data" action="{{route('propertytypes.store')}}">
                        <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                        @csrf
                        @include('admin.property-types.form')
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="user-save" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection