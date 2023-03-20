@extends('admin.layout.app')
@section('page_title', 'Edit Meal Plan')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Edit Meal Plan</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmMealPlans" class="needs-validation1" novalidate method="post"
                            enctype="multipart/form-data" action="{{ route('mealplans.update', $model) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.meal-plans.form')
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('mealplans.index') }}">{{ __('core.back') }}</a>
                                    <button type="submit" id="user-save" class="btn btn-primary"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
