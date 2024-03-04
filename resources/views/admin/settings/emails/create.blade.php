@extends('admin.layout.app')
@section('page_title', 'Email Settings')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Send Email Settings</h4>
                    </div>
                    <div class="card-body">
                        @if (isset($model->id))
                        <form id="FrmEmailSettings" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('settings.update',$model->id) }}">
                            @method('PUT')
                        @else
                        <form id="FrmEmailSettings" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('settings.store') }}">
                        @endif
                        
                            @csrf
                            <input type="hidden" name="type" value="Email Setting">
                            @include('admin.settings.emails.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
