@extends('admin.layout.app')
@section('page_title', 'HB Emails Settings')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">HB Emails Settings</h4>
                    </div>
                    <div class="card-body">
                        @if (isset($model->id))
                        <form id="FrmEmailsSettings" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('setting-hb-email-update', $model->id ) }}">
                            
                        @else
                        <form id="FrmEmailsSettings" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('setting-hb-email-add') }}">
                        @endif
                        
                            @csrf
                            <input type="hidden" name="type" value="2">
                            @include('admin.settings.hb-emails.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
