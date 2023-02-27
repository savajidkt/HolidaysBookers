@extends('admin.layout.app')
@section('page_title',__('agent/agent.form_add_page_title'))
@section('content')

<section class="bs-validation">
    <div class="row">
        <!-- Bootstrap Validation -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header bg-primary bg-lighten-2 colors-container">
                    <h4 class="card-title text-white">{{__('agent/agent.form_add_page_title')}}</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation1" id="FrmAgent" method="post" enctype="multipart/form-data" action="{{route('agents.store')}}">
                        <input type="hidden" name="id" value="{{ isset($model->id) ? $model->id : null }}">
                        @csrf
                        @include('admin.agent.form')
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="user-save" class="btn btn-primary">{{__('core.submit')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</section>
@endsection
@section('extra-script')

<script type="text/javascript">
    jQuery(function() {
        function generatePassword() {
            return Math.random() // Generate random number, eg: 0.123456
                .toString(36) // Convert  to base-36 : "0.4fzyo82mvyr"
                .slice(-8); // Cut off last 8 characters : "yo82mvyr"
        }
        jQuery('#generate_password').on('click', function() {
            var password = generatePassword();
            jQuery('#password').val(password);
            jQuery('#confirm-password').val(password);
        });

    })
</script>
@endsection