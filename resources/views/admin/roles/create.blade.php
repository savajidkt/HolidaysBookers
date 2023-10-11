@extends('admin.layout.app')
@section('page_title','New Role')
@section('content')
<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Role</h4>
                </div>
                <div class="card-body">
                    <form id="FrmRoles" class="needs-validation1" method="post" enctype="multipart/form-data" action="{{route('roles.store')}}">
                        <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                        @csrf
                        @include('admin.roles.form')
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection