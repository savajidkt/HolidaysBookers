@extends('admin.layout.app')
@section('page_title', 'Global Markup Settings')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Global Markup Settings</h4>
                    </div>
                    <div class="card-body">
                        @if (isset($model->id))
                        <form id="FrmMarkupSettings" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('setting-global-markup-update', $model->id ) }}">
                            
                        @else
                        <form id="FrmMarkupSettings" class="needs-validation1" method="post" enctype="multipart/form-data"
                            action="{{ route('setting-global-markup-add') }}">
                        @endif
                        
                            @csrf
                            <input type="hidden" name="type" value="1">
                            @include('admin.settings.markup.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
