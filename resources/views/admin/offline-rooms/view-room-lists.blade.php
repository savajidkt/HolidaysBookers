@extends('admin.layout.app')
@section('page_title', 'View Offline Rooms')
@section('content')
<script>
    var HotelsList = "";
    var HotelsRoomType = "";
    var HotelsRoomMealPlan = "";
    var HotelsAmenities = "";
    var HotelsFreebies = "";
    var HotelsRoomID = "";
    var HotelsRoomMealPlanID = "";
    var HotelsAmenitiesIDs = [];
    var HotelsFreebiesIDs = [];
    var HotelID = 0;
    var currencyList = [];
    var currencyIDs = "";
</script>
@if ($offlinehotel)
    <script>
        var HotelID = "{!! $offlinehotel->id !!}";
    </script>
@endif

<div class="card-header border-bottom d-flex justify-content-between align-items-center my-2">
   
    <div class="col-md-6">
        <a class="btn btn-outline-secondary waves-effect" href="{{ route('offlinehotels.show', $offlinehotel->id) }}">Back</a>
    </div>
    <div class="col-md-6 text-right">                
        <a href="{{ route('room-create', $offlinehotel->id) }}" class="btn btn-primary btn-sm waves-effect waves-float waves-light" data-toggle="tooltip" data-original-title="Add New Room" data-animation="false"><i class="fa fa-plus" aria-hidden="true"></i></a>                
    </div>
</div>
    <section class="form-control-repeater">
        <div class="row">
            <!-- Bootstrap Validation -->
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header bg-primary bg-lighten-2 colors-container">
                        <h4 class="card-title text-white">{{ $offlinehotel->hotel_name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row HotelWiseRooms mt-15 ">
                            <div class="col-12">
                                <div class="card-datatable pt-0 table-responsive">
                                    <table class="hotel-rooms-list-table datatables-ajax table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th></th>
                                                <th>{{ __('core.id') }}</th>
                                                <th>Hotel Name</th>
                                                <th>Room Type</th>
                                                <th>Adult</th>
                                                <th>CWB</th>
                                                <th>CNB</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('extra-script')
    <script src="{{ asset('app-assets/js/scripts/pages/app-user-list.js') }}"></script>
    <script src="{{ asset('js/form/Offline-Room.js') }}"></script>   
    <script type="text/javascript">
        var moduleConfig = {
            addRoomTypeURL: "{!! route('add-room-type') !!}",
            addRoomMealPlanURL: "{!! route('add-meal-plan') !!}",
            addAmenityURL: "{!! route('add-amenity') !!}",
            addFreebiesURL: "{!! route('add-freebies') !!}",
            addRoomsURL: "{!! route('offlinerooms.store') !!}",
            listRoomsURL: "{!! route('offlinerooms.index') !!}",
            getHotelRoomsURL: "{!! route('get-hotel-rooms-url', '') !!}",
            changeRoomsStatusURL: "{!! route('change-offline-room-status', '') !!}",
        };
    </script>
@endsection