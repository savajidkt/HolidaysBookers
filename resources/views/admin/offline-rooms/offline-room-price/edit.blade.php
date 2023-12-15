@extends('admin.layout.app')
@section('page_title', 'Edit Room Price')
@section('content')
    <section class="bs-validation">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">Edit Room Price</h4>
                    </div>
                    <div class="card-body">
                        <form id="FrmOfflineRoomPrice" class="" novalidate method="post" enctype="multipart/form-data"
                            action="{{ route('edit-room-price', $pricemodel) }}">
                            @csrf                            
                            @include('admin.offline-rooms.offline-room-price.form')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a class="btn btn-outline-secondary btn-sm waves-effect"
                                        href="{{ route('view-room-price', $model) }}">{{ __('core.back') }}</a>
                                    <button type="submit" id="user-save" class="btn btn-primary btn-sm"><span
                                            class="spinner-border spinner-border-sm buttonLoader hide" role="status"
                                            aria-hidden="true"></span><span
                                            class="ml-25 align-middle">{{ __('core.update') }}</span></button>
                                </div>
                            </div>
                        </form>
                        <div class="modal fade text-left" id="roomMealPlanBTN" tabindex="-1"
                    aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel120">Add Meal Plan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <form action="" method="post" id="FrmMealPlan"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="basic-addon-name">Meal
                                                        Plan<span class="text-danger">*</span></label>
                                                    <input type="text" id="basic-addon-name" name="name"
                                                        class="form-control" placeholder="Meal Plan" value=""
                                                        aria-describedby="basic-addon-name" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                                        data-error="Meal plan name is required" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm waves-effect waves-float waves-light"><span
                                                        class="spinner-border spinner-border-sm buttonLoader hide"
                                                        role="status" aria-hidden="true"></span><span
                                                        class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade text-left" id="surchargePlan" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg modal-simple" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Surcharge</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="surchargePlanFrm"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="hotel_id" id="hotel_id">                                                            
                                                    <input type="hidden" name="id" id="id">                                                            
                                                    <input type="hidden" name="action" id="action" value="add">                                                            
                                                    <div class="row g-3">
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Surcharge Name</label>
                                                            <input type="text" name="surcharge_name" class="form-control" placeholder="Surcharge Name">                                                            

                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plLastName">Surcharge Price</label>
                                                            <input type="text" name="surcharge_price"
                                                                class="form-control" placeholder="10000">                                                            
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="form-label" for="plUserName">Surcharge Date</label>                                                            

                                                                <input type="text" id="surcharge_date" name="surcharge_date"
                                                                class="form-control basic-surcharge flatpickr-input" placeholder="DD-MM-YYYY To DD-MM-YYYY"
                                                                value =""
                                                                data-error="Surcharge date is required" />
                                                            
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm waves-effect waves-float waves-light"><span
                                                                class="spinner-border spinner-border-sm buttonLoader hide"
                                                                role="status" aria-hidden="true"></span><span
                                                                class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                    </div>
                                                    <div class="modal-footer listFooter">
                                                        <div class="col-12">
                                                            <ul class="list-group">
                                                                
                                                            </ul>                                                            
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left" id="complimentaryPlan" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg modal-simple" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Complimentary</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="complimentaryPlanFrm"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="hotel_id" id="hotel_id">                                                            
                                                    <input type="hidden" name="id" id="id">                                                            
                                                    <input type="hidden" name="action" id="action" value="add">                                                            
                                                    <div class="row g-3">
                                                        <div class="col-sm-6 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Complimentary Name</label>
                                                            <input type="text" name="complimentary_name" class="form-control" placeholder="Complimentary Name">                                                            

                                                        </div>
                                                        <div class="col-sm-6 fv-plugins-icon-container">
                                                            <label class="form-label" for="plLastName">Complimentary Price</label>
                                                            <input type="text" name="complimentary_price"
                                                                class="form-control" placeholder="10000">                                                            
                                                        </div>                                                       

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm waves-effect waves-float waves-light"><span
                                                                class="spinner-border spinner-border-sm buttonLoader hide"
                                                                role="status" aria-hidden="true"></span><span
                                                                class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                    </div>
                                                    <div class="modal-footer listFooter">
                                                        <div class="col-12">
                                                            <ul class="list-group">
                                                                
                                                            </ul>                                                            
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                <div class="modal fade text-left" id="promotionalPlan" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg modal-simple" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Promotional</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="promotionalPlanFrm"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="hotel_id" id="hotel_id">
                                                    <input type="hidden" name="id" id="id">
                                                    <input type="hidden" name="action" id="action" value="add">
                                                    <div class="row g-3">
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Single Adult</label>
                                                            <input type="number" name="single_adult" class="form-control" placeholder="Single Adult">
                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Per Room</label>
                                                            <input type="number" name="per_room" class="form-control" placeholder="Per Room">
                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Extra Adult</label>
                                                            <input type="number" name="extra_adult" class="form-control" placeholder="Extra Adult">
                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Child with Bed</label>
                                                            <input type="number" name="child_with_bed" class="form-control" placeholder="Child with Bed">
                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Child no Bed (0-4 Years)</label>
                                                            <input type="number" name="child_with_no_bed_0_4" class="form-control" placeholder="Child no Bed (0-4 Years)">
                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Child no Bed (5-12 Years)</label>
                                                            <input type="number" name="child_with_no_bed_5_12" class="form-control" placeholder="Child no Bed (5-12 Years)">
                                                        </div>
                                                        <div class="col-sm-4 fv-plugins-icon-container">
                                                            <label class="form-label" for="plFirstName">Child no Bed (13-18 Years)</label>
                                                            <input type="number" name="child_with_no_bed_13_18" class="form-control" placeholder="Child no Bed (13-18 Years)">
                                                        </div>
                                                        
                                                        <div class="col-sm-4">
                                                            <label class="form-label" for="plUserName">Date Validity</label>
                                                            <input type="text" id="date_validity"
                                                                name="date_validity"
                                                                class="form-control basic-promotional flatpickr-input"
                                                                placeholder="DD-MM-YYYY To DD-MM-YYYY" value =""
                                                                data-error="Date validity date is required" />

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer mt-2">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm waves-effect waves-float waves-light"><span
                                                                class="spinner-border spinner-border-sm buttonLoader hide"
                                                                role="status" aria-hidden="true"></span><span
                                                                class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                    </div>
                                                    <div class="modal-footer listFooter">
                                                        <div class="col-12">
                                                            <ul class="list-group">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                <div class="modal fade text-left" id="stopSalePlan" tabindex="-1"
                            aria-labelledby="myModalLabel120" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-lg modal-simple" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel120">Stop Sale</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <form action="" method="post" id="stopSalePlanFrm"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="hotel_id" id="hotel_id">
                                                    <input type="hidden" name="id" id="id">
                                                    <input type="hidden" name="action" id="action" value="add">
                                                    <div class="row">
                                                    <div class="col-sm-8">
                                                        <label class="form-label" for="plUserName">Stop Sale
                                                            Date</label>
                                                        <input type="text" id="stop_sale_date"
                                                            name="stop_sale_date"
                                                            class="form-control basic-stopSale flatpickr-input"
                                                            placeholder="DD-MM-YYYY" value =""
                                                            data-error="Stop Sale date is required" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="submit"
                                                            class="mt-2 btn btn-primary btn-ml waves-effect waves-float waves-light"><span
                                                                class="spinner-border spinner-border-sm buttonLoader hide"
                                                                role="status" aria-hidden="true"></span><span
                                                                class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                                                    </div>
                                                    </div>
                                                   
                                                    <div class="modal-footer listFooter mt-2">
                                                        <div class="col-12">
                                                            <ul class="list-group">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </section>
@endsection
