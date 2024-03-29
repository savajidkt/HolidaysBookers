@extends('admin.layout.app')
@section('page_title','Edit Role')
@section('content')
<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Role</h4>
                </div>
                <div class="card-body">
                    <form id="FrmRoles" class="needs-validation1" novalidate method="post" enctype="multipart/form-data" action="{{route('roles.update', $model)}}">
                        @csrf
                        @method('PUT')
                        @include('admin.roles.form')
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection