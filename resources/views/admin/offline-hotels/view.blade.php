@extends('admin.layout.app')
@section('page_title', 'Hotel View')
@section('content')
    <div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">

        <div class="col-md-6">
            <a class="btn btn-outline-secondary waves-effect" href="{{ route('offlinehotels.index') }}">Back</a>
        </div>        
    </div>
    <section id="page-account-settings">
        <div class="card">

            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title">Hotel : #{{ $model->hotel_name }}</h4>
                </div>
            </div>

        </div>
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-hotel-details" data-toggle="pill"
                            href="#account-vertical-hotel-details" aria-expanded="true">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">HOTEL DETAILS</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-front-office" data-toggle="pill"
                            href="#account-vertical-front-office" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">FRONT OFFICE</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-sales" data-toggle="pill" href="#account-vertical-sales"
                            aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">SALES & MANAGEMENT</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-reservation" data-toggle="pill"
                            href="#account-vertical-reservation" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">RESERVATION</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="account-pill-galleries-details" data-toggle="pill"
                            href="#account-vertical-galleries-details" aria-expanded="false">
                            <i data-feather='arrow-right-circle'></i>
                            <span class="font-weight-bold">GALLERY</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="account-vertical-hotel-details"
                                aria-labelledby="account-pill-hotel-details" aria-expanded="true">
                                <div class="row">

                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Country</strong>
                                            <span
                                                class="disp-below">{{ isset($model->country->name) ? $model->country->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">City</strong>
                                            <span
                                                class="disp-below">{{ isset($model->city->name) ? $model->city->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Category</strong>
                                            <span class="disp-below">{{ isset($model->category) ? $model->category : '' }}
                                                Star</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Hotel Group</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotelgroup->name) ? $model->hotelgroup->name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Phone Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->phone_number) ? $model->phone_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Fax Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->fax_number) ? $model->fax_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Address</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_address) ? $model->hotel_address : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Pincode</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_pincode) ? $model->hotel_pincode : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_email) ? $model->hotel_email : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Hotel Freebies</strong>
                                            <span class="disp-below">{{ $freebiesName }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Hotel Amenities</strong>
                                            <span class="disp-below">{{ $amenitiesName }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Property Type</strong>
                                            <span
                                                class="disp-below">{{ isset($model->property->property_name) ? $model->property->property_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Rating</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_review) ? $model->hotel_review : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Latitude</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_latitude) ? $model->hotel_latitude : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Longitude</strong>
                                            <span
                                                class="disp-below">{{ isset($model->hotel_longitude) ? $model->hotel_longitude : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Cancel Days</strong>
                                            <span
                                                class="disp-below">{{ isset($model->cancel_days) ? $model->cancel_days : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username"> Hotel Description </strong>
                                            <span class="disp-below">{!! isset($model->hotel_description) ? $model->hotel_description : '' !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <strong for="account-username">Cancellation Policy</strong>
                                            <span class="disp-below">{!! isset($model->cancellation_policy) ? $model->cancellation_policy : '' !!}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="account-vertical-front-office" role="tabpanel"
                                aria-labelledby="account-front-office" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_first_name) ? $model->front_office_first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Designation</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_designation) ? $model->front_office_designation : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Contact Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_contact_number) ? $model->front_office_contact_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->front_office_email) ? $model->front_office_email : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-sales" role="tabpanel"
                                aria-labelledby="account-sales" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_first_name) ? $model->sales_first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Designation</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_designation) ? $model->sales_designation : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Contact Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_contact_number) ? $model->sales_contact_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->sales_email) ? $model->sales_email : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-reservation" role="tabpanel"
                                aria-labelledby="account-reservation" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Name</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_first_name) ? $model->reservation_first_name : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Designation</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_designation) ? $model->reservation_designation : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Contact Number</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_contact_number) ? $model->reservation_contact_number : '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <strong for="account-username">Email</strong>
                                            <span
                                                class="disp-below">{{ isset($model->reservation_email) ? $model->reservation_email : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-galleries-details" role="tabpanel"
                                aria-labelledby="account-pill-galleries-details" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Galleries</h4>
                                            </div>
                                            <div class="card-body">
                                                @if ($model->images->count() > 0)
                                                    <div id="carouselExampleFade" class="carousel slide carousel-fade"
                                                        data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @php
                                                                $i = 0;
                                                            @endphp
                                                            @foreach ($model->images as $image)
                                                                <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                                                    <img src="{{ url('storage/app/upload/Hotel/' . $model->id . '/gallery/' . $image['file_path']) }}"
                                                                        class="img-fluid d-block w-100" alt="cf-img-1" />
                                                                </div>
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                            @endforeach
                                                            @if (strlen($model->hotel_image_location) > 0)
                                                                <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                                                    <img src="{{ url('storage/app/upload/Hotel/' . $model->id . '/' . $model->hotel_image_location) }}"
                                                                        class="img-fluid d-block w-100" alt="cf-img-1"
                                                                        style="height: 550px !important;" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExampleFade"
                                                            role="button" data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExampleFade"
                                                            role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <p class="card-text">
                                                        Hotel galleries not found!
                                                    </p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
    @if ($offlineRoom)
        <section id="accordion-with-margin">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card collapse-icon">
                        <div class="card-header">
                            <h4 class="card-title">Hotel Rooms</h4>
                            <a href="{{ route('room-create', $model->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add Room" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i> Add Room</a> 
                        </div>
                        <div class="card-body">
                            <div class="collapse-margin" id="accordionExample">
                                @foreach ($offlineRoom as $room)
                                    <div class="card">
                                        <div class="card-header collapsed" id="room_{{ $room->id }}"
                                            data-toggle="collapse" role="button"
                                            data-target="#collapse_room_{{ $room->id }}" aria-expanded="false"
                                            aria-controls="collapse_room_{{ $room->id }}">
                                            <span class="lead collapse-title"> {{ $room->roomtype->room_type }} </span>
                                        </div>
                                        <hr>
                                        <div id="collapse_room_{{ $room->id }}" class="collapse"
                                            aria-labelledby="room_{{ $room->id }}" data-parent="#accordionExample"
                                            style="">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-sm-2">
                                                        <div class="form-group">
                                                            <strong for="account-username">Max Occupancy</strong>
                                                            <span class="disp-below">{{ $room->occ_sleepsmax }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-1">
                                                        <div class="form-group">
                                                            <strong for="account-username">No. of Beds</strong>
                                                            <span class="disp-below">{{ $room->occ_num_beds }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-1">
                                                        <div class="form-group">
                                                            <strong for="account-username">Max Adults</strong>
                                                            <span class="disp-below">{{ $room->occ_max_adults }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2">
                                                        <div class="form-group">
                                                            <strong for="account-username">Max Children When Max
                                                                Adults</strong>
                                                            <span
                                                                class="disp-below">{{ $room->occ_max_child_w_max_adults }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2">
                                                        <div class="form-group">
                                                            <strong for="account-username">Max Children Without Extra
                                                                Bed</strong>
                                                            <span
                                                                class="disp-below">{{ $room->occ_max_child_wo_extra_bed }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2">
                                                        <div class="form-group">
                                                            <strong for="account-username">Status</strong>
                                                            <span class="disp-below">@php echo $room->status_name; @endphp</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-2">
                                                        <div class="form-group">
                                                            <strong for="account-username">Action</strong>
                                                            <span class="disp-below">                                                                
                                                                <a href="{{ route('offlinerooms.edit', $room->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Edit Room" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> 
                                                                <a href="{{ route('view-room', $room->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="View Room" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a> 
                                                                <a href="#" class="delete_action_room btn btn-danger btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete Room" data-animation="false" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true"></i>
                                                                    <form action="{{  route('offlinerooms.destroy', $room->id) }}" method="POST" name="delete_item" style="display:none">
                                                                        @csrf
                                                                        <input type="hidden" name="_method" value="delete">                                                                                                
                                                                        </form>
                                                                    </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($room->price)
                                                    <div class="row" id="">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="card-title">Room Price</h4>
                                                                    <a href="{{ route('add-room-price', $room->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Add Room Price" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i> Add Room Price</a> 
                                                                </div>
                                                                <div class="table-responsive">
                                                                    <table class="table ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Travel Date Validity</th>
                                                                                <th>Booking Date Validity</th>
                                                                                <th>Single Adult</th>
                                                                                <th>Per Room</th>
                                                                                
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($room->price as $price)     
                                                                            
                                                                                <tr>
                                                                                    <td>
                                                                                        <span class="font-weight-bold">{{ $price->from_date .' - '.$price->to_date }}</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span class="font-weight-bold">{{ $price->booking_start_date .' - '.$price->booking_end_date }}</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        {{ getNumberWithCommaGivenCurrency($price->price_p_n_single_adult, $price->currency->symbol) }}
                                                                                    </td>                                                                                    
                                                                                    <td>                                                                                        
                                                                                        {{ getNumberWithCommaGivenCurrency($price->price_p_n_twin_sharing, $price->currency->symbol) }}
                                                                                    </td>
                                                                                    <td>

                                                                                        
                                                                                        <a href="{{ route('edit-room-price', $price->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Edit Room Price" data-animation="false"><i class="fa fa-edit" aria-hidden="true"></i></a> 
                                                                                        <a href="{{ route('show-room-price', $price->id) }}" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="View Room Price" data-animation="false"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                                                                                        <a href="#" class="delete_action_price btn btn-danger hhhh btn-sm" data-method="delete" data-toggle="tooltip" data-original-title="Delete Room Price" data-animation="false"><i class="fa fa-trash" aria-hidden="true"></i>
                                                                                            
                                                                                            <form action="{{ route('delete-room-price', $price->id) }}" method="POST" name="delete_item" style="display:none">
                                                                                                @csrf
                                                                                                <input type="hidden" name="_method" value="delete">                                                                                                
                                                                                                </form>
                                                                                        </a>
                                                                                        
                                                                                        
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('extra-script')
    

    <script type="text/javascript">
       

       $(document).on('click', '.delete_action_room', function(e) {
                
                e.preventDefault();
                var $this = $(this);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won`t be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $this.find("form").trigger('submit');
                    }
                });
            });
            
            $(document).on('click', '.delete_action_price', function(e) {
                
                e.preventDefault();
                var $this = $(this);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won`t be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "{{ __('core.cancel') }}",
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $this.find("form").trigger('submit');
                    }
                });
            });
       
    </script>
@endsection

