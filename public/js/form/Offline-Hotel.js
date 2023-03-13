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


    var OfflineHotelAmenities = function () {
        var selectAmenities = $('.select2-hotel-amenities');
        var hotelAmenitiesData = [
            { id: '', text: '' }
        ];
        $.each(HotelsAmenities, function (key, val) {
            hotelAmenitiesData.push({ id: key, text: val });
        });
        selectAmenities.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Amenities",
            allowClear: true,
            dropdownAutoWidth: true,
            dropdownParent: selectAmenities.parent(),
            width: '100%',
            data: hotelAmenitiesData
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            FrmOfflineRoomValidation();
            OfflineHotelAmenities();
        }
    };
}();

$(document).ready(function () {
    FrmOfflineRoomPreference.init();
});