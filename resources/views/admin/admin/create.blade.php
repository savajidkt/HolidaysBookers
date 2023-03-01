@extends('admin.layout.app')
@section('page_title','New Staff')
@section('content')
<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Staff</h4>
                </div>
                <div class="card-body">
                    <form id="jquery-val-form" class="needs-validation1" method="post" enctype="multipart/form-data" action="{{route('admins.store')}}">
                        <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                        @csrf
                        @include('admin.admin.form')
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection