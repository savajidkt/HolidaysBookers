var FrmOfflineRoomPreference = function () {
    var FrmOfflineRoomValidation = function () {
        var FrmOfflineRoomPreferenceForm = $('#FrmOfflineRoom');
        var error4 = $('.error-message', FrmOfflineRoomPreferenceForm);
        var success4 = $('.error-message', FrmOfflineRoomPreferenceForm);

        FrmOfflineRoomPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: { required: true },
                room_type: { required: true },
                room_amenities: { required: true },
                max_pax: { required: true },
                min_pax: { required: true },
                no_of_cwb: { required: true },
                no_of_cnb: { required: true },
                no_of_adult: { required: true },
                status: { required: true },
                price_type: { required: true },
                start_date: { required: true },
                end_date: { required: true },
                double_occupancy: { required: true },
                single_occupancy: { required: true },
                extra_pax_price: { required: true },
            },
            messages: {
                hotel_id: {
                    required: 'Hotel is required'
                },
                room_type: {
                    required: 'Room type is required'
                },
                room_amenities: {
                    required: 'Room amenities is required'
                },
                max_pax: {
                    required: 'Max pax is required'
                },
                min_pax: {
                    required: 'Min pax is required'
                },
                no_of_cwb: {
                    required: 'No of CWB is required'
                },
                no_of_cnb: {
                    required: 'No of CNB is required'
                },
                no_of_adult: {
                    required: 'No of Adult is required'
                },
                status: {
                    required: 'Status is required'
                },
                price_type: {
                    required: 'Price type is required'
                },
                start_date: {
                    required: 'Start date is required'
                },
                end_date: {
                    required: 'End date is required'
                },
                double_occupancy: {
                    required: 'Double occupancy is required'
                },
                single_occupancy: {
                    required: 'Single occupancy is required'
                },
                extra_pax_price: {
                    required: 'Extra Pax Price is required'
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "price_type") {
                    error.insertAfter(".price_typeCLS");
                } else if (element.attr("name") == "hotel_id") {
                    error.insertAfter(".hotel_idCLS");
                } else if (element.attr("name") == "room_type") {
                    error.insertAfter(".room_typeCLS");
                } else if (element.attr("name") == "room_amenities") {
                    error.insertAfter(".room_amenitiesCLS");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }

    var FrmOfflineRoomPriceType = function () {
        $('input:radio[name=price_type]').change(function () {
            if ($(this).val() == 0) {
                $('.is_stop_sale').addClass('hide');
            } else {
                $('.is_stop_sale').removeClass('hide');
            }
        });
    }

    var OfflineHotel = function () {
        var selectHotel = $('.select2-hotel');
        var hotelData = [
            { id: '', text: '' }
        ];
        $.each(HotelsList, function (key, val) {
            hotelData.push({ id: key, text: val });
        });
        selectHotel.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Hotel",
            allowClear: true,
            dropdownAutoWidth: true,
            dropdownParent: selectHotel.parent(),
            width: '100%',
            data: hotelData
        });
    }

    var OfflineHotelRooms = function () {
        var selectRoomType = $('.select2-room-types');
        var hotelRoomData = [
            { id: '', text: '' }
        ];
        $.each(HotelsRoomType, function (key, val) {
            hotelRoomData.push({ id: key, text: val });
        });

        selectRoomType.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Room",
            allowClear: true,
            dropdownAutoWidth: true,
            dropdownParent: selectRoomType.parent(),
            width: '100%',
            data: hotelRoomData
        });        
        $('.select2-room-types').val(HotelsRoomID);
        $('.select2-room-types').trigger('change');

    }
    var OfflineHotelAmenities = function () {
        var selectAmenities = $('.select2-room-amenities');
        var hotelAmenitiesData = [
            { id: '', text: '' }
        ];
        $.each(HotelsAmenities, function (key, val) {
            hotelAmenitiesData.push({ id: key, text: val });
        });

        selectAmenities.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Amenities",
            allowClear: true,
            multiple: true,
            dropdownAutoWidth: true,
            dropdownParent: selectAmenities.parent(),
            width: '100%',
            data: hotelAmenitiesData
        });

        $('.select2-room-amenities').val(HotelsAmenitiesIDs);
        $('.select2-room-amenities').trigger('change');
    }

    var FrmAddAmenity = function () {
        var FrmRoomAmenityPreferenceForm = $('#FrmroomAmenity');
        var error4 = $('.error-message', FrmRoomAmenityPreferenceForm);
        var success4 = $('.error-message', FrmRoomAmenityPreferenceForm);

        FrmRoomAmenityPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                amenity_name: {
                    required: true,
                }
            },
            messages: {
                amenity_name: {
                    required: $("input[name=amenity_name]").attr('data-error')
                }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $("#FrmroomAmenity .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmroomAmenity .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addAmenityURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            HotelsAmenities = data.responce;
                            OfflineHotelAmenities();
                            $('#roomAmenityBTN').modal('hide');
                        }
                        $("#FrmroomAmenity .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var FrmAddRoomType = function () {
        var FrmRoomTypePreferenceForm = $('#FrmroomType');
        var error4 = $('.error-message', FrmRoomTypePreferenceForm);
        var success4 = $('.error-message', FrmRoomTypePreferenceForm);

        FrmRoomTypePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                room_type: {
                    required: true
                }
            },
            messages: {
                room_type: {
                    required: $("input[name=room_type]").attr('data-error')
                }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $("#FrmroomType .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmroomType .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addRoomTypeURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            HotelsRoomType = data.responce;
                            OfflineHotelRooms();
                            $('#roomTypeBTN').modal('hide');
                        }
                        $("#FrmroomType .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            FrmOfflineRoomValidation();
            FrmOfflineRoomPriceType();
            OfflineHotel();
            OfflineHotelRooms();
            OfflineHotelAmenities();
            FrmAddAmenity();
            FrmAddRoomType();
        }
    };
}();

$(document).ready(function () {
    FrmOfflineRoomPreference.init();
    $(document).on('click', '.roomTypeBTN', function () {
        $('#roomTypeBTN').modal('show');
    });
    $(document).on('click', '.roomAmenityBTN', function () {
        $('#roomAmenityBTN').modal('show');
    });
});