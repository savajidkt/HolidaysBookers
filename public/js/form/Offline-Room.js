var dt_table_hotels;
var varHotelsID = HotelID;
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
                hotel_id: {
                    required: true
                },

            },
            messages: {
                hotel_id: {
                    required: 'Hotel is required'
                },
            },
            errorPlacement: function (error, element) {


                if (element.attr("name") == "price_type") {
                    error.insertAfter(".price_typeCLS");
                } else if (element.attr("name") == "hotel_id") {
                    error.insertAfter(".hotel_idCLS");
                } else if (element.attr("name").indexOf('[room_type]') >= 0) {                    
                    error.insertAfter(".room_typeCLS");
                } else if (element.attr("name").indexOf('[room_amenities]') >= 0) {
                    error.insertAfter(".room_amenitiesCLS");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                //$(".buttonLoader").removeClass('hide');               
                var form_data = new FormData(form);

                jQuery('.roomImageDropzone').each(function (index, currentElement) {
                    var fileUpload = $('#roomImageDropzone_' + index).get(0).dropzone;
                    var files = fileUpload.files;
                    for (var i = 0; i < files.length; i++) {
                        form_data.append(files[i].name, files[i]);
                        form_data.append("room_image[" + index + "][]", files[i]);
                    }
                });

                jQuery('.roomGalleryDropzone').each(function (index, currentElement) {
                    var fileUpload = $('#roomGalleryDropzone_' + index).get(0).dropzone;
                    var files = fileUpload.files;
                    for (var i = 0; i < files.length; i++) {
                        form_data.append(files[i].name, files[i]);
                        form_data.append("room_gallery_image[" + index + "][]", files[i]);
                    }
                });


                $.ajax({
                    beforeSend: function () {
                        $(".buttonLoader").removeClass('hide');
                    },
                    complete: function (data) {
                        $(".buttonLoader").addClass('hide');
                    },
                    error: function (data) {
                    },
                    type: "post",
                    url: moduleConfig.addRoomsURL,
                    data: form_data,
                    dataType: 'json',
                    'global': false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        window.location = moduleConfig.listRoomsURL;
                    },
                    error: function (x, t, m) {
                    }
                });

                //form.submit();
            }
        });
    }

    var FrmEditOfflineRoomValidation = function () {
        var FrmOfflineRoomPreferenceForm = $('#FrmEditOfflineRoom');
        var error4 = $('.error-message', FrmOfflineRoomPreferenceForm);
        var success4 = $('.error-message', FrmOfflineRoomPreferenceForm);

        FrmOfflineRoomPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: {
                    required: true
                },
                room_type: {
                    required: true
                },
                "room_amenities[]": {
                    required: true
                },
                meal_plan: {
                    required: true
                },
                "room_freebies[]": {
                    required: true
                },
                max_pax: {
                    required: true
                },
                min_pax: {
                    required: true
                },
                no_of_cwb: {
                    required: true
                },
                no_of_cnb: {
                    required: true
                },
                no_of_adult: {
                    required: true
                },
                status: {
                    required: true
                },

            },
            messages: {
                hotel_id: {
                    required: 'Hotel is required'
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
                //$(".buttonLoader").removeClass('hide');               
                var form_data = new FormData(form);

                var fileUpload = $('#roomImageDropzone_0').get(0).dropzone;
                var files = fileUpload.files;
                for (var i = 0; i < files.length; i++) {
                    form_data.append(files[i].name, files[i]);
                    form_data.append("room_image[]", files[i]);
                }
                var fileUpload = $('#roomGalleryDropzone_0').get(0).dropzone;
                var files = fileUpload.files;
                for (var i = 0; i < files.length; i++) {
                    form_data.append(files[i].name, files[i]);
                    form_data.append("room_gallery_image[]", files[i]);
                }


                $.ajax({
                    beforeSend: function () {
                        $(".buttonLoader").removeClass('hide');
                    },
                    complete: function (data) {
                        $(".buttonLoader").addClass('hide');
                    },
                    error: function (data) {
                    },
                    type: "post",
                    url: moduleConfig.editRoomURL,
                    data: form_data,
                    dataType: 'json',
                    'global': false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        window.location = moduleConfig.editRoomURL + '/edit';
                    },
                    error: function (x, t, m) {
                    }
                });

                //form.submit();
            }
        });
    }
    var FrmOfflineRoomPriceValidation = function () {
        var FrmOfflineRoomPreferenceForm = $('#FrmOfflineRoomPrice');
        var error4 = $('.error-message', FrmOfflineRoomPreferenceForm);
        var success4 = $('.error-message', FrmOfflineRoomPreferenceForm);

        FrmOfflineRoomPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                price_type: {
                    required: true
                },
                start_date: {
                    required: true
                },
                end_date: {
                    required: true
                },
                booking_start_date: {
                    required: true
                },
                booking_end_date: {
                    required: true
                },
                currency_id: {
                    required: true
                },
                cutoff_price: {
                    required: true
                },
                min_nights: {
                    required: true
                },
                min_overall_nights: {
                    required: true
                },
                price_p_n_single_adult: {
                    required: true
                },
                price_p_n_twin_sharing: {
                    required: true
                },
                price_p_n_extra_adult: {
                    required: true
                },
                price_p_n_cwb: {
                    required: true
                },
                price_p_n_cob: {
                    required: true
                },
                price_p_n_ccob: {
                    required: true
                },
                tax_p_n_single_adult: {
                    required: true
                },
                tax_p_n_twin_sharing: {
                    required: true
                },
                tax_p_n_extra_adult: {
                    required: true
                },
                tax_p_n_cwb: {
                    required: true
                },
                tax_p_n_cob: {
                    required: true
                },
                tax_p_n_ccob: {
                    required: true
                },
                market_price: {
                    required: true
                },
                'days_valid[]': {
                    required: true
                },

            },
            groups: {
                travelGroup: "start_date end_date",
                bookingGroup: "booking_start_date booking_end_date",
            },

            messages: {

                price_type: {
                    required: 'Price type is required'
                },
                start_date: {
                    required: 'Travel date validity is required'
                },
                end_date: {
                    required: 'Travel date validity is required'
                },
                booking_start_date: {
                    required: 'Booking date validity is required'
                },
                booking_end_date: {
                    required: 'Booking date validity is required'
                },
                currency_id: {
                    required: $("select[name=currency_id]").attr('data-error')
                },
                cutoff_price: {
                    required: $("select[name=cutoff_price]").attr('data-error')
                },
                min_nights: {
                    required: $("select[name=min_nights]").attr('data-error')
                },
                min_overall_nights: {
                    required: $("select[name=min_overall_nights]").attr('data-error')
                },
                price_p_n_single_adult: {
                    required: $("input[name=price_p_n_single_adult]").attr('data-error')
                },
                price_p_n_twin_sharing: {
                    required: $("input[name=price_p_n_twin_sharing]").attr('data-error')
                },
                price_p_n_extra_adult: {
                    required: $("input[name=price_p_n_extra_adult]").attr('data-error')
                },
                price_p_n_cwb: {
                    required: $("input[name=price_p_n_cwb]").attr('data-error')
                },
                price_p_n_cob: {
                    required: $("input[name=price_p_n_cob]").attr('data-error')
                },
                price_p_n_ccob: {
                    required: $("input[name=price_p_n_ccob]").attr('data-error')
                },
                tax_p_n_single_adult: {
                    required: $("input[name=tax_p_n_single_adult]").attr('data-error')
                },
                tax_p_n_twin_sharing: {
                    required: $("input[name=tax_p_n_twin_sharing]").attr('data-error')
                },
                tax_p_n_extra_adult: {
                    required: $("input[name=tax_p_n_extra_adult]").attr('data-error')
                },
                tax_p_n_cwb: {
                    required: $("input[name=tax_p_n_cwb]").attr('data-error')
                },
                tax_p_n_cob: {
                    required: $("input[name=tax_p_n_cob]").attr('data-error')
                },
                tax_p_n_ccob: {
                    required: $("input[name=tax_p_n_ccob]").attr('data-error')
                },
                market_price: {
                    required: $("input[name=market_price]").attr('data-error')
                },
                'days_valid[]': {
                    required: 'Days valid is required'
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "price_type") {
                    error.insertAfter(".price_typeCLS");
                } else if (element.attr("name") == "start_date" || element.attr("name") == "end_date") {
                    error.insertAfter(".TravelDateValidity");
                } else if (element.attr("name") == "booking_start_date" || element.attr("name") == "booking_end_date") {
                    error.insertAfter(".BookingDateValidity");
                } else if (element.attr("name") == "currency_id") {
                    error.insertAfter(".CurrencyError");
                } else if (element.attr("name") == "days_valid[]") {
                    error.insertAfter(".days_validError");
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
                // $('.is_stop_sale').addClass('hide');
            } else {
                // $('.is_stop_sale').removeClass('hide');
            }
        });
    }

    var OfflineHotel = function () {
        var selectHotel = $('.select2-hotel');
        var hotelData = [{
            id: '',
            text: ''
        }];
        $.each(HotelsList, function (key, val) {
            hotelData.push({
                id: key,
                text: val
            });
        });
        selectHotel.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Hotel",
            allowClear: true,
            dropdownAutoWidth: true,
            dropdownParent: selectHotel.parent(),
            width: '100%',
            data: hotelData
        });

        $('.select2-hotel').val(HotelID);
        $('.select2-hotel').trigger('change');

        $(".select2-hotel").on('change', function (e) {
            var data = $(this).select2('data');
            varHotelsID = data[0].id;
            dt_table_hotels.ajax.reload();
            // dt_table_hotels.draw();
            //    $('.HotelWiseRooms').removeClass('hide');
        });
    }

    var getHotelRooms = function () {
        //console.log(data[0].id);
        // if (varHotelsID !== "" && varHotelsID !== 0) {
        //     $('.HotelWiseRooms').removeClass('hide');
        // } 
        //return false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        dt_table_hotels = $('.hotel-rooms-list-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            order: [
                [1, 'desc']
            ],
            ajax: {
                'url': moduleConfig.getHotelRoomsURL + '/' + varHotelsID,
                'data': function (data) {
                    data.hotel_id = varHotelsID;
                }

            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                { data: 'id', visible: false },
                { data: 'hotel_name', name: 'hotel_name' },
                { data: 'room_type', name: 'room_type' },
                { data: 'occ_sleepsmax', name: 'occ_sleepsmax' },
                { data: 'occ_num_beds', name: 'occ_num_beds' },
                { data: 'occ_max_adults', name: 'occ_max_adults' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        }).on('click', '.delete_action', function (e) {
            e.preventDefault();
            var $this = $(this);
            Swal.fire({
                title: "Are you sure?",
                text: "You won`t be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: "Yes, delete it!",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $this.find("form").trigger('submit');
                }
            });
        }).on('click', '.status_update', function (e) {
            e.preventDefault();
            var $this = $(this),
                offline_room_id = $this.data('offline_room_id'),

                status = $this.data('status'),
                message = status == 1 ?
                    "Are you sure you want to deactivate room?" :
                    "Are you sure you want to activate room?";


            Swal.fire({
                title: "Update Room status",
                text: message,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: "Yes",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: moduleConfig.changeRoomsStatusURL,
                        dataType: 'json',
                        data: {
                            offline_room_id: offline_room_id,
                            status: status
                        },
                        success: function (data) {
                            if (data.status) {
                                dt_table_hotels.ajax.reload();
                            }
                        }

                    });
                }
            });

            return false;
        });

    }

    var OfflineHotelRooms = function () {
        var selectRoomType = $('.select2-room-types');
        var hotelRoomData = [{
            id: '',
            text: ''
        }];
        $.each(HotelsRoomType, function (key, val) {
            hotelRoomData.push({
                id: key,
                text: val
            });
        });

        selectRoomType.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Room",
            allowClear: true,
            tags: true,
            dropdownAutoWidth: true,
            dropdownParent: selectRoomType.parent(),
            width: '100%',
            data: hotelRoomData
        });
        $('.select2-room-types').val(HotelsRoomID);
        $('.select2-room-types').trigger('change');

    }
    var OfflineHotelRoomsMealPlan = function () {
        var selectRoomType = $('.select2-room-meal-plan');
        var hotelRoomData = [{
            id: '',
            text: ''
        }];
        $.each(HotelsRoomMealPlan, function (key, val) {
            hotelRoomData.push({
                id: key,
                text: val
            });
        });

        selectRoomType.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Meal Plan",
            allowClear: true,
            tags: true,
            dropdownAutoWidth: true,
            dropdownParent: selectRoomType.parent(),
            width: '100%',
            data: hotelRoomData
        });
        $('.select2-room-meal-plan').val(HotelsRoomMealPlanID);
        $('.select2-room-meal-plan').trigger('change');

    }
    var OfflineHotelAmenities = function () {
        var selectAmenities = $('.select2-room-amenities');
        var hotelAmenitiesData = [{
            id: '',
            text: ''
        }];
        $.each(HotelsAmenities, function (key, val) {
            hotelAmenitiesData.push({
                id: key,
                text: val
            });
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

    var OfflineHotelFreebies = function () {
        var selectAmenities = $('.select2-room-freebies');
        var hotelAmenitiesData = [{
            id: '',
            text: ''
        }];
        $.each(HotelsFreebies, function (key, val) {
            hotelAmenitiesData.push({
                id: key,
                text: val
            });
        });

        selectAmenities.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Freebies",
            allowClear: true,
            multiple: true,
            dropdownAutoWidth: true,
            dropdownParent: selectAmenities.parent(),
            width: '100%',
            data: hotelAmenitiesData
        });

        $('.select2-room-freebies').val(HotelsFreebiesIDs);
        $('.select2-room-freebies').trigger('change');
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

                            var datas = [];
                            $.each(HotelsAmenities, function (key, val) {
                                datas.push({
                                    id: key,
                                    text: val
                                });
                            });
                            $(".select2-room-amenities").select2({
                                data: datas
                            });
                            $('input[name="amenity_name"]').val('');
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
                            var datas = [];
                            $.each(HotelsRoomType, function (key, val) {
                                datas.push({
                                    id: key,
                                    text: val
                                });
                            });
                            $(".select2-room-types").select2({
                                data: datas
                            });
                            $('input[name="room_type"]').val('');
                            $('#roomTypeBTN').modal('hide');
                        }
                        $("#FrmroomType .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var FrmAddRoomMealPlan = function () {
        var FrmMealPlanPreferenceForm = $('#FrmMealPlan');
        var error4 = $('.error-message', FrmMealPlanPreferenceForm);
        var success4 = $('.error-message', FrmMealPlanPreferenceForm);

        FrmMealPlanPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
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
                        $("#FrmMealPlan .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmMealPlan .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addRoomMealPlanURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            HotelsRoomType = data.responce;
                            var datas = [];
                            $.each(HotelsRoomType, function (key, val) {
                                datas.push({
                                    id: key,
                                    text: val
                                });
                            });
                            $(".select2-room-meal-plan").select2({
                                data: datas
                            });
                            $('input[name="name"]').val('');
                            $('#roomMealPlanBTN').modal('hide');
                        }
                        $("#FrmMealPlan .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var FrmAddFreebies = function () {
        var FrmFreebiesPreferenceForm = $('#FrmFreebies');
        var error4 = $('.error-message', FrmFreebiesPreferenceForm);
        var success4 = $('.error-message', FrmFreebiesPreferenceForm);

        FrmFreebiesPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: $("#FrmFreebies input[name=name]").attr('data-error')
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
                        $("#FrmFreebies .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmFreebies .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addFreebiesURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            HotelsAmenities = data.responce;
                            var datas = [];
                            $.each(HotelsAmenities, function (key, val) {
                                datas.push({
                                    id: key,
                                    text: val
                                });
                            });
                            $(".select2-room-freebies").select2({
                                data: datas
                            });
                            $('#FrmFreebies input[name="name"]').val('');
                            $('#roomFreebiesBTN').modal('hide');
                        }
                        $("#FrmFreebies .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var OfflineCurrency = function () {
        var selectCurrency = $('.select2-room-currency');
        var currencyData = [{
            id: '',
            text: ''
        }];
        $.each(currencyList, function (key, val) {
            currencyData.push({
                id: val.id,
                text: val.name + '(' + val.code + ')'
            });
        });

        selectCurrency.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Currency",
            allowClear: true,
            multiple: false,
            dropdownAutoWidth: true,
            dropdownParent: selectCurrency.parent(),
            width: '100%',
            data: currencyData
        });

        $('.select2-room-currency').val(currencyIDs);
        $('.select2-room-currency').trigger('change');
    }

    return {
        //main function to initiate the module
        init: function () {
            FrmOfflineRoomValidation();
            FrmOfflineRoomPriceType();
            OfflineHotel();
            OfflineHotelRooms();
            OfflineHotelRoomsMealPlan();
            OfflineHotelAmenities();
            FrmAddAmenity();
            FrmAddRoomType();
            FrmOfflineRoomPriceValidation();
            FrmEditOfflineRoomValidation();
            getHotelRooms();
            OfflineHotelFreebies();
            FrmAddRoomMealPlan();
            FrmAddFreebies();
            OfflineCurrency();
        }
    };
}();

$(document).ready(function () {
    FrmOfflineRoomPreference.init();
    $(document).on('click', '.roomMealPlanBTN', function () {
        $('#roomMealPlanBTN').modal('show');
    });
    $(document).on('click', '.roomTypeBTN', function () {
        $('#roomTypeBTN').modal('show');
    });
    $(document).on('click', '.roomAmenityBTN', function () {
        $('#roomAmenityBTN').modal('show');
    });
    $(document).on('click', '.roomFreebiesBTN', function () {
        $('#roomFreebiesBTN').modal('show');
    });


    $('#rate_offered').change(function () {
        if ($(this).val() == 'NET_RATE') {
            $('.is_rate_offered').addClass('hide');
        } else {
            $('.is_rate_offered').removeClass('hide');
        }
    });
});
