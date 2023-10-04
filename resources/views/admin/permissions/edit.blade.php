@extends('admin.layout.app')
@section('page_title','Edit Permission')
@section('content')
<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Permission</h4>
                </div>
                <div class="card-body">
                    <form id="FrmPermission" class="needs-validation1" novalidate method="post" enctype="multipart/form-data" action="{{route('permissions.update', $model)}}">
                        @csrf
                        @method('PUT')
                        @include('admin.permissions.form')
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