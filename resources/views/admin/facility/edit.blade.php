@extends('admin.layout.app')
@section('page_title', 'Edit Hotel Facility')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Hotel Facility</h4>
                       
                    </div>
                    <div class="card-body">
                        <form id="FrmHotelFacility" class="needs-validation1" novalidate method="post"
                            enctype="multipart/form-data" action="{{ route('hotelfacility.update', $model) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.facility.form')
                            <div class="row">
                                <div class="col-12">

                                    <a class="btn btn-outline-secondary waves-effect"
                                        href="{{ route('hotelfacility.index') }}">{{ __('core.back') }}</a>
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

    <section class="bs-validation">
        <div class="row">            
            <div class="col-md-12 col-12">
                <div class="card">
                    
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Sub Facilities</h4>        
                        <a href="{{ route('hotelfacilities.create').'?facility_id='.$model->id }}"><button type="reset"
                                class="btn btn-primary mr-1 waves-effect waves-float waves-light">New Sub Facility</button></a>
                            </div>
                    <div class="card-body">
                        <table class="user-list-table datatables-ajax table">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>{{ __('core.id') }}</th>
                                    <th>Name</th>                                   
                                    <th>{{ __('core.status') }}</th>
                                    <th>{{ __('core.action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>                   

                </div>
            </div>
        </div>
    </section>
@endsection