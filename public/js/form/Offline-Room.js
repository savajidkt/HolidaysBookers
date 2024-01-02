var dt_table_hotels;
var varHotelsID = HotelID;
var selectedMealId;
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
                $(".buttonLoader").removeClass('hide');
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
                // status: {
                //     required: true
                // },

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
            },
            groups: {
                //travelGroup: "start_date end_date",
                //bookingGroup: "booking_start_date booking_end_date",
            },

            messages: {

                price_type: {
                    required: 'Price type is required'
                },
                start_date: {
                    required: 'Travel date validity is required'
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

    var FrmOfflineRoomPriceCancelationPolicy = function () {

        $('.Cancelation-Policy input[type=radio]').change(function () {

            if ($(this).val() == 'refundeble') {

                $('.div_cancelation_policy').removeClass('hide');

            } else {
                $('.div_cancelation_policy').addClass('hide');
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

        var dt_table_hdt_column_search_hotel_rooms = $('.dt-column-search-hotel-rooms-list');

        if (dt_table_hdt_column_search_hotel_rooms.length) {
            // Setup - add a text input to each footer cell
            $('.dt-column-search-hotel-rooms-list thead tr').clone(true).appendTo('.dt-column-search-hotel-rooms-list thead');
            $('.dt-column-search-hotel-rooms-list thead tr:eq(0) th').each(function (i) {
                var title = $(this).text();

                if (i == 0) {

                } else if (i == 7) {
                    $(this).html(
                        '<select name="status" class="form-control form-control-sm" id="status"><option value="">Select Status</option><option value="1"> Active</option><option value="0"> Inactive</option></select>'
                    );
                    $('select', this).on('change', function () {
                        if (dt_table_hotels.column(i).search() !== this.value) {
                            dt_table_hotels.column(i).search(this.value).draw();
                        }
                    });
                } else if (i == 8) {
                    $(this).html('');
                } else {
                    $(this).html(
                        '<input type="text" class="form-control form-control-sm" placeholder="Search ' +
                        title + '" />');
                    $('input', this).on('keyup change', function () {
                        if (dt_table_hotels.column(i).search() !== this.value) {
                            dt_table_hotels.column(i).search(this.value).draw();
                        }
                    });
                }
            });
        }

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
    var OfflineHotelRoomsMealPlanComplimentary = function () {
        var selectRoomType = $('.select2-room-meal-plan-complimentary');
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
            placeholder: "Select Complimentary",
            allowClear: true,
            tags: true,
            dropdownAutoWidth: true,
            dropdownParent: selectRoomType.parent(),
            width: '100%',
            data: hotelRoomData
        });
        //$('.select2-room-meal-plan-complimentary').val(selectedMealId);
        $('.select2-room-meal-plan-complimentary').trigger('change');

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

    var FrmAddSurcharge = function () {
        var FrmSurchargePlanPreferenceForm = $('#surchargePlanFrm');
        var error4 = $('.error-message', FrmSurchargePlanPreferenceForm);
        var success4 = $('.error-message', FrmSurchargePlanPreferenceForm);

        FrmSurchargePlanPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: {
                    required: true
                },
                surcharge_name: {
                    required: true
                },
                surcharge_price: {
                    required: true
                },
                surcharge_date: {
                    required: true,
                    dateRangeFuncation: true
                },
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
                        //$("#surchargePlanFrm .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        //$("#surchargePlanFrm .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addRoomSurchargePlanURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            jQuery('.listFooter .list-group').html('');
                            $('#surchargePlanFrm .modal-footer .btn-primary span').html('');
                            $('#surchargePlanFrm .modal-footer .btn-primary span').html('Submit');
                            $('#surchargePlanFrm #id').val('');
                            $('#surchargePlanFrm #action').val('');
                            $("input[name='surcharge_name']").val('');
                            $("input[name='surcharge_price']").val('');
                            $("input[name='surcharge_date']").val('');
                            $.each(data.responce, function (k, v) {
                                jQuery('.listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium">' + v.surcharge_name + '</p><span>' + v.surcharge_date_start + ' To ' + v.surcharge_date_end + '</span><h5 class="card-title mb-0">' + v.surcharge_price + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');
                            });
                        }
                        $("#surchargePlanFrm .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var FrmAddComplimentary = function () {
        var FrmComplimentaryPlanPreferenceForm = $('#complimentaryPlanFrm');
        var error4 = $('.error-message', FrmComplimentaryPlanPreferenceForm);
        var success4 = $('.error-message', FrmComplimentaryPlanPreferenceForm);

        FrmComplimentaryPlanPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: {
                    required: true
                },
                id: {
                    required: true
                },
                complimentary_name: {
                    required: true
                },
                complimentary_price: {
                    required: true
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
                        //$("#surchargePlanFrm .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        //$("#surchargePlanFrm .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addRoomComplimentaryPlanURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            jQuery('.listFooter .list-group').html('');
                            $('#complimentaryPlanFrm .modal-footer .btn-primary span').html('');
                            $('#complimentaryPlanFrm .modal-footer .btn-primary span').html('Submit');
                            if( jQuery('#complimentaryPlanFrm input[name="action"]').val() == "update" ){                               
                                $('#complimentaryPlanFrm #id').val('');
                                $('#complimentaryPlanFrm #id').val($('.complimentaryPlan').attr('data-room-id'));
                                $('#complimentaryPlanFrm #action').val('');
                                $('#complimentaryPlanFrm #action').val('add');
                            }
                           
                            complimentarySelected('');                            
                            $("input[name='complimentary_price']").val('');

                            $.each(data.responce, function (k, v) {
                                jQuery('.listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium">' + v.mealplans.name + '</p><h5 class="card-title mb-0">' + v.complimentary_price + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editComplimentarybtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltComplimentarybtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');
                            });
                        }
                        $("#complimentaryPlanFrm .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var FrmAddStopSale = function () {
        var FrmStopSalePlanPreferenceForm = $('#stopSalePlanFrm');
        var error4 = $('.error-message', FrmStopSalePlanPreferenceForm);
        var success4 = $('.error-message', FrmStopSalePlanPreferenceForm);

        FrmStopSalePlanPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: {
                    required: true
                },
                stop_sale_date: {
                    required: true
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
                        //$("#surchargePlanFrm .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        //$("#surchargePlanFrm .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addRoomStopSalePlanURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            jQuery('#stopSalePlanFrm .listFooter .list-group').html('');
                            $('#stopSalePlanFrm .btn-primary span').html('');
                            $('#stopSalePlanFrm .btn-primary span').html('Submit');
                            $('#stopSalePlanFrm #action').val('add');
                            $("input[name='stop_sale_date']").val('');
                            $.each(data.responce, function (k, v) {
                                var date_start = "";
                                const date = new Date(v.stop_sale_date);
                                date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                                jQuery('#stopSalePlanFrm .listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><h5 class="card-title mb-0">' + date_start + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editStopSalebtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltStopSalebtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');
                            });
                        }
                        $("#stopSalePlanFrm .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }
    var FrmAddPromotionals = function () {
        var FrmPromotionalPlanPreferenceForm = $('#promotionalPlanFrm');
        var error4 = $('.error-message', FrmPromotionalPlanPreferenceForm);
        var success4 = $('.error-message', FrmPromotionalPlanPreferenceForm);

        FrmPromotionalPlanPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: {
                    required: true
                },
                single_adult: {
                    required: true
                },
                per_room: {
                    required: true
                },
                extra_adult: {
                    required: true
                },
                child_with_bed: {
                    required: true
                },
                child_with_no_bed_0_4: {
                    required: true
                },
                child_with_no_bed_5_12: {
                    required: true
                },
                child_with_no_bed_13_18: {
                    required: true
                },
                date_validity: {
                    required: true
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
                        //$("#surchargePlanFrm .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        //$("#surchargePlanFrm .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addRoomPromotionalPlanURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            jQuery('#promotionalPlanFrm .listFooter .list-group').html('');
                            $('#promotionalPlanFrm .btn-primary span').html('');
                            $('#promotionalPlanFrm .btn-primary span').html('Submit');
                            $('#promotionalPlanFrm #action').val('add');

                            $("input[name='single_adult']").val('');
                            $("input[name='per_room']").val('');
                            $("input[name='extra_adult']").val('');
                            $("input[name='child_with_bed']").val('');
                            $("input[name='child_with_no_bed_0_4']").val('');
                            $("input[name='child_with_no_bed_5_12']").val('');
                            $("input[name='child_with_no_bed_13_18']").val('');
                            $("input[name='date_validity']").val('');


                            $.each(data.responce, function (k, v) {
                                var date_start = "";
                                var date_end = "";
                                const date = new Date(v.date_validity_start);
                                date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                                const date1 = new Date(v.date_validity_end);
                                date_end = date1.getDate() + ' ' + date1.toLocaleString('default', { month: 'short' }) + ' ' + date1.getFullYear();
                                jQuery('#promotionalPlan .listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium"> Single Adult: <b>' + v.single_adult + '</b></p><p class="mb-0 fw-medium"> Per Room: <b>' + v.per_room + '</b></p><p class="mb-0 fw-medium"> Extra Adult: <b>' + v.extra_adult + '</b></p><p class="mb-0 fw-medium"> Child with Bed: <b>' + v.child_with_bed + '</b></p><p class="mb-0 fw-medium"> Child no Bed (0-4 Years): <b>' + v.child_with_no_bed_0_4 + '</b></p><p class="mb-0 fw-medium"> Child no Bed (5-12 Years): <b>' + v.child_with_no_bed_5_12 + '</b></p><p class="mb-0 fw-medium"> Child no Bed (13-18 Years): <b>' + v.child_with_no_bed_13_18 + '</b></p><h5 class="card-title mb-0">' + date_start + ' To ' + date_end + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editPromotionalsbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltPromotionalsbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Delete</button></div></li>');
                            });
                        }
                        $("#promotionalPlanFrm .buttonLoader").addClass('hide');
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
            OfflineHotelRoomsMealPlanComplimentary();
            OfflineHotelAmenities();
            FrmAddAmenity();
            FrmAddRoomType();
            FrmOfflineRoomPriceValidation();
            FrmEditOfflineRoomValidation();
            getHotelRooms();
            OfflineHotelFreebies();
            FrmAddRoomMealPlan();
            FrmAddSurcharge();
            FrmAddComplimentary();
            FrmAddStopSale();
            FrmAddPromotionals();
            FrmAddFreebies();
            OfflineCurrency();
            FrmOfflineRoomPriceCancelationPolicy();
        }
    };
}();

$(document).ready(function () {
    FrmOfflineRoomPreference.init();
    $(document).on('click', '.surchargePlan', function () {
        $('#surchargePlanFrm #hotel_id').val($(this).attr('data-hotel-id'));
        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomSurchargePlanListURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
            },
            success: function (data) {
                if (data.status) {
                    jQuery('.listFooter .list-group').html('');
                    $.each(data.responce, function (k, v) {
                        var date_start = "";
                        var date_end = "";
                        const date = new Date(v.surcharge_date_start);
                        date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                        const date1 = new Date(v.surcharge_date_end);
                        date_end = date1.getDate() + ' ' + date1.toLocaleString('default', { month: 'short' }) + ' ' + date1.getFullYear();

                        jQuery('.listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium">' + v.surcharge_name + '</p><span>' + date_start + ' To ' + date_end + '</span><h5 class="card-title mb-0">' + v.surcharge_price + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Delete</button></div></li>');
                    });
                }
                $('#surchargePlan').modal('show');
            }
        });

    });

    $(document).on('click', '.listFooter .editbtn', function () {

        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomSurchargePlanListEditURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
                id: $(this).attr('data-id'),
            },
            success: function (data) {
                if (data.status) {
                    $("input[name='surcharge_name']").val(data.responce[0].surcharge_name);
                    $("input[name='surcharge_price']").val(data.responce[0].surcharge_price);                   
                    var date_start = "";
                    var date_end = "";
                    const date = new Date(data.responce[0].surcharge_date_start);
                    var dateMonth = parseInt(date.getMonth()) + parseInt(1);
                    date_start = date.getDate() + '/' + dateMonth + '/' + date.getFullYear();
                    const date1 = new Date(data.responce[0].surcharge_date_end);
                    var dateMonth1 = parseInt(date1.getMonth()) + parseInt(1);
                    date_end = date1.getDate() + '/' + dateMonth1 + '/' + date1.getFullYear();  


                    var surchargeBasic = $('.basic-surcharge');
                    if (surchargeBasic.length) {
                        surchargeBasic.flatpickr({
                            mode: 'range',
                            dateFormat: "d/m/Y",
                            defaultDate: [date_start, date_end],
                        });
                    }
                    $('#surchargePlanFrm .modal-footer .btn-primary span').html('');
                    $('#surchargePlanFrm .modal-footer .btn-primary span').html('Update');
                    $('#surchargePlanFrm #id').val(data.responce[0].id);
                    $('#surchargePlanFrm #action').val('update');
                }

                $('#surchargePlan').modal('show');
            }
        });
    });

    $(document).on('click', '.listFooter .dltbtn', function () {
        var hotel_id = $(this).attr('data-hotel-id');
        var id = $(this).attr('data-id');


        Swal.fire({
            title: "Are you sure?",
            text: "You won`t be able to delete this!",
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
                $.ajax({
                    type: 'POST',
                    url: moduleConfig.addRoomSurchargePlanListDeleteURL,
                    dataType: 'json',
                    data: {
                        hotel_id: hotel_id,
                        id: id,
                    },
                    success: function (data) {
                        if (data.status) {
                            jQuery('.listFooter .list-group').html('');
                            $.each(data.responce, function (k, v) {
                                var date_start = "";
                                var date_end = "";
                                const date = new Date(v.surcharge_date_start);
                                date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                                const date1 = new Date(v.surcharge_date_end);
                                date_end = date1.getDate() + ' ' + date1.toLocaleString('default', { month: 'short' }) + ' ' + date1.getFullYear();

                                jQuery('.listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium">' + v.surcharge_name + '</p><span>' + date_start + ' To ' + date_end + '</span><h5 class="card-title mb-0">' + v.surcharge_price + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Delete</button></div></li>');
                            });
                        }
                        $('#surchargePlan').modal('show');
                    }
                });
            }
        });
    });

    $(document).on('click', '.complimentaryPlan', function () {
        $('#complimentaryPlan #hotel_id').val($(this).attr('data-hotel-id'));
        $('#complimentaryPlan #id').val($(this).attr('data-room-id'));

        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomComplimentaryPlanListURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
                room_id: $(this).attr('data-room-id'),
            },
            success: function (data) {
                if (data.status) {
                    complimentarySelected('');
                    $("input[name='complimentary_price']").val('');
                    jQuery('.listFooter .list-group').html('');
                    $.each(data.responce, function (k, v) {
                        jQuery('.listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium">' + v.mealplans.name + '</p><h5 class="card-title mb-0">' + v.complimentary_price + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editComplimentarybtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltComplimentarybtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');
                    });
                }
                $('#complimentaryPlan').modal('show');
            }
        });

    });

    $(document).on('click', '.listFooter .editComplimentarybtn', function () {

        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomComplimentaryPlanListEditURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
                id: $(this).attr('data-id'),
            },
            success: function (data) {
                if (data.status) {
                    complimentarySelected(data.responce[0].mealplans_id);                    
                    
                    $("input[name='complimentary_price']").val(data.responce[0].complimentary_price);

                    $('#complimentaryPlan .modal-footer .btn-primary span').html('');
                    $('#complimentaryPlan .modal-footer .btn-primary span').html('Update');
                    $('#complimentaryPlan #id').val(data.responce[0].id);
                    $('#complimentaryPlan #action').val('update');
                }

                $('#complimentaryPlan').modal('show');
            }
        });
    });

    $(document).on('click', '.listFooter .dltComplimentarybtn', function () {
        var hotel_id = $(this).attr('data-hotel-id');
        var id = $(this).attr('data-id');


        Swal.fire({
            title: "Are you sure?",
            text: "You won`t be able to delete this!",
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
                $.ajax({
                    type: 'POST',
                    url: moduleConfig.addRoomComplimentaryPlanListDeleteURL,
                    dataType: 'json',
                    data: {
                        hotel_id: hotel_id,
                        id: id,
                    },
                    success: function (data) {
                        if (data.status) {
                            jQuery('.listFooter .list-group').html('');
                            $.each(data.responce, function (k, v) {

                                $('#complimentaryPlanFrm .modal-footer .btn-primary span').html('');
                                $('#complimentaryPlanFrm .modal-footer .btn-primary span').html('Submit');

                                $('#complimentaryPlanFrm #action').val('add');
                                complimentarySelected('')
                                $("input[name='complimentary_price']").val('');

                                jQuery('.listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium">' + v.mealplans.name + '</p><h5 class="card-title mb-0">' + v.complimentary_price + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editComplimentarybtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltComplimentarybtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');
                            });
                        }
                        $('#complimentaryPlan').modal('show');
                    }
                });
            }
        });
    });

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
    $('#cutoff_price').change(function () {
        $('.before_check_in_days').html('');
        var optionStr = "";
        if ($(this).val() > 1) {
            for (let index = 0; index < $(this).val(); index++) {
                optionStr += "<option value=\"" + index + "\">" + index + " Days</option>";
            }
            $('.before_check_in_days').html(optionStr);
        } else {
            optionStr += "<option value=\"0\">0 Days</option>";
            $('.before_check_in_days').html(optionStr);
        }
    });

    jQuery.validator.addMethod("dateRangeFuncation", function () {
        var dateStr = jQuery("#surcharge_date").val();
        const dateArr = dateStr.split(' to ');

        if (dateArr[0] === undefined || dateArr[0] === null || dateArr[0] === "") {
            return false;
        } else if (dateArr[1] === undefined || dateArr[1] === null || dateArr[1] === "") {
            return false;
        } else {
            return true;
        }

    }, "Please check your dates.");

    $(document).on('click', '.stopSalePlan', function () {

        $('#stopSalePlan #hotel_id').val($(this).attr('data-hotel-id'));
        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomStopSalePlanListURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
            },
            success: function (data) {
                if (data.status) {
                    jQuery('#stopSalePlan .listFooter .list-group').html('');
                    $.each(data.responce, function (k, v) {
                        var date_start = "";
                        const date = new Date(v.stop_sale_date);                        
                        date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                        jQuery('#stopSalePlanFrm .listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><h5 class="card-title mb-0">' + date_start + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editStopSalebtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltStopSalebtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');
                    });
                }
                $('#stopSalePlan').modal('show');
            }
        });

    });
    $(document).on('click', '.listFooter .editStopSalebtn', function () {

        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomStopSalePlanListEditURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
                id: $(this).attr('data-id'),
            },
            success: function (data) {
                if (data.status) {
                    $("input[name='stop_sale_date']").val(data.responce[0].stop_sale_date);
                   
                    var date_start = "";                    
                    const date = new Date(data.responce[0].stop_sale_date);
                    var dateMonth = parseInt(date.getMonth()) + parseInt(1);
                    date_start = date.getDate() + '/' + dateMonth + '/' + date.getFullYear();                    


                    var surchargeBasic = $('.basic-stopSale');
                    if (surchargeBasic.length) {
                        surchargeBasic.flatpickr({
                            dateFormat: "d/m/Y",
                            defaultDate: [date_start],
                        });
                    }
                    $('#stopSalePlan .btn-primary span').html('');
                    $('#stopSalePlan .btn-primary span').html('Update');
                    $('#stopSalePlan #id').val(data.responce[0].id);
                    $('#stopSalePlan #action').val('update');
                }

                $('#stopSalePlan').modal('show');
            }
        });
    });
    $(document).on('click', '.listFooter .dltStopSalebtn', function () {
        var hotel_id = $(this).attr('data-hotel-id');
        var id = $(this).attr('data-id');


        Swal.fire({
            title: "Are you sure?",
            text: "You won`t be able to delete this!",
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
                $.ajax({
                    type: 'POST',
                    url: moduleConfig.addRoomStopSalePlanListDeleteURL,
                    dataType: 'json',
                    data: {
                        hotel_id: hotel_id,
                        id: id,
                    },
                    success: function (data) {
                        if (data.status) {
                            jQuery('.listFooter .list-group').html('');
                            $.each(data.responce, function (k, v) {

                                $('#stopSalePlan .btn-primary span').html('');
                                $('#stopSalePlan .btn-primary span').html('Submit');

                                $('#stopSalePlan #action').val('add');
                                $("input[name='stop_sale_date']").val('');

                                var date_start = "";
                                const date = new Date(v.stop_sale_date);
                                date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                                jQuery('#stopSalePlanFrm .listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><h5 class="card-title mb-0">' + date_start + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editStopSalebtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltStopSalebtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Delete</button></div></li>');


                            });
                        }
                        $('#stopSalePlan').modal('show');
                    }
                });
            }
        });
    });

    $(document).on('click', '.promotionalPlan', function () {
        $('#promotionalPlan').modal('show');
        $('#promotionalPlan #hotel_id').val($(this).attr('data-hotel-id'));
        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomPromotionalPlanListURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
            },
            success: function (data) {
                if (data.status) {
                    jQuery('.listFooter .list-group').html('');
                    $.each(data.responce, function (k, v) {
                        var date_start = "";
                        var date_end = "";
                        const date = new Date(v.date_validity_start);
                        date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                        const date1 = new Date(v.date_validity_end);
                        date_end = date1.getDate() + ' ' + date1.toLocaleString('default', { month: 'short' }) + ' ' + date1.getFullYear();
                        jQuery('#promotionalPlan .listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium"> Single Adult: <b>' + v.single_adult + '</b></p><p class="mb-0 fw-medium"> Per Room: <b>' + v.per_room + '</b></p><p class="mb-0 fw-medium"> Extra Adult: <b>' + v.extra_adult + '</b></p><p class="mb-0 fw-medium"> Child with Bed: <b>' + v.child_with_bed + '</b></p><p class="mb-0 fw-medium"> Child no Bed (0-4 Years): <b>' + v.child_with_no_bed_0_4 + '</b></p><p class="mb-0 fw-medium"> Child no Bed (5-12 Years): <b>' + v.child_with_no_bed_5_12 + '</b></p><p class="mb-0 fw-medium"> Child no Bed (13-18 Years): <b>' + v.child_with_no_bed_13_18 + '</b></p><h5 class="card-title mb-0">' + date_start + ' To ' + date_end + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editPromotionalsbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltPromotionalsbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Delete</button></div></li>');
                    });
                }
                $('#promotionalPlan').modal('show');
            }
        });

    });
    $(document).on('click', '.listFooter .editPromotionalsbtn', function () {
        $.ajax({
            type: 'POST',
            url: moduleConfig.addRoomPromotionalPlanListEditURL,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
                id: $(this).attr('data-id'),
            },
            success: function (data) {
                if (data.status) {

                    $("input[name='single_adult']").val(data.responce[0].single_adult);
                    $("input[name='per_room']").val(data.responce[0].per_room);
                    $("input[name='extra_adult']").val(data.responce[0].extra_adult);
                    $("input[name='child_with_bed']").val(data.responce[0].child_with_bed);
                    $("input[name='child_with_no_bed_0_4']").val(data.responce[0].child_with_no_bed_0_4);
                    $("input[name='child_with_no_bed_5_12']").val(data.responce[0].child_with_no_bed_5_12);
                    $("input[name='child_with_no_bed_13_18']").val(data.responce[0].child_with_no_bed_13_18);

                    var date_start = "";
                    var date_end = "";
                    const date = new Date(data.responce[0].date_validity_start);
                    var dateMonth = parseInt(date.getMonth()) + parseInt(1);
                    date_start = date.getDate() + '/' + dateMonth + '/' + date.getFullYear();
                    const date1 = new Date(data.responce[0].date_validity_end);
                    var dateMonth1 = parseInt(date1.getMonth()) + parseInt(1);
                    date_end = date1.getDate() + '/' + dateMonth1 + '/' + date1.getFullYear();                 

                    var promotionalBasic = $('.basic-promotional');
                    if (promotionalBasic.length) {
                        promotionalBasic.flatpickr({
                            mode: 'range',
                            dateFormat: "d/m/Y",
                            defaultDate: [date_start, date_end],
                        });
                    }
                    $('#promotionalPlan .modal-footer .btn-primary span').html('');
                    $('#promotionalPlan .modal-footer .btn-primary span').html('Update');
                    $('#promotionalPlan #id').val(data.responce[0].id);
                    $('#promotionalPlan #action').val('update');
                }

                $('#promotionalPlan').modal('show');
            }
        });
    });
    $(document).on('click', '.listFooter .dltPromotionalsbtn', function () {

        var hotel_id = $(this).attr('data-hotel-id');
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won`t be able to delete this!",
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
                $.ajax({
                    type: 'POST',
                    url: moduleConfig.addRoomPromotionalPlanListDeleteURL,
                    dataType: 'json',
                    data: {
                        hotel_id: hotel_id,
                        id: id,
                    },
                    success: function (data) {
                        if (data.status) {
                            jQuery('#promotionalPlan .listFooter .list-group').html('');
                            $.each(data.responce, function (k, v) {

                                $('#promotionalPlan .btn-primary span').html('');
                                $('#promotionalPlan .btn-primary span').html('Submit');

                                $('#promotionalPlan #action').val('add');
                                ("input[name='single_adult']").val('');
                                $("input[name='per_room']").val('');
                                $("input[name='extra_adult']").val('');
                                $("input[name='child_with_bed']").val('');
                                $("input[name='child_with_no_bed_0_4']").val('');
                                $("input[name='child_with_no_bed_5_12']").val('');
                                $("input[name='child_with_no_bed_13_18']").val('');
                                $("input[name='date_validity']").val('');

                                var date_start = "";
                                var date_end = "";
                                const date = new Date(v.date_validity_start);
                                date_start = date.getDate() + '/' + (parseInt(date.getMonth()) + parseInt(1)) + '/' + date.getFullYear();
                                const date1 = new Date(v.date_validity_end);
                                date_end = date1.getDate() + ' ' + date1.toLocaleString('default', { month: 'short' }) + ' ' + date1.getFullYear();
                                jQuery('#promotionalPlan .listFooter .list-group').append('<li class="list-group-item d-flex justify-content-between flex-column flex-sm-row"><div class="offer"><p class="mb-0 fw-medium"> Single Adult: <b>' + v.single_adult + '</b></p><p class="mb-0 fw-medium"> Per Room: <b>' + v.per_room + '</b></p><p class="mb-0 fw-medium"> Extra Adult: <b>' + v.extra_adult + '</b></p><p class="mb-0 fw-medium"> Child with Bed: <b>' + v.child_with_bed + '</b></p><p class="mb-0 fw-medium"> Child no Bed (0-4 Years): <b>' + v.child_with_no_bed_0_4 + '</b></p><p class="mb-0 fw-medium"> Child no Bed (5-12 Years): <b>' + v.child_with_no_bed_5_12 + '</b></p><p class="mb-0 fw-medium"> Child no Bed (13-18 Years): <b>' + v.child_with_no_bed_13_18 + '</b></p><h5 class="card-title mb-0">' + date_start + ' To ' + date_end + '</h5></div><div class="apply mt-3 mt-sm-0"><button type="button" class="btn btn-outline-primary waves-effect editPromotionalsbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + '>Edit</button><button type="button" class="btn btn-outline-primary waves-effect dltPromotionalsbtn" data-hotel-id=' + v.hotel_id + ' data-id=' + v.id + ' >Delete</button></div></li>');


                            });
                        }
                        $('#promotionalPlan').modal('show');
                    }
                });
            }
        });
    });

});


function complimentarySelected(id){
    var selectRoomType = $('.select2-room-meal-plan-complimentary');
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
                                placeholder: "Select Complimentary",
                                allowClear: true,
                                tags: true,
                                dropdownAutoWidth: true,
                                dropdownParent: selectRoomType.parent(),
                                width: '100%',
                                data: hotelRoomData
                            });
                            if( id ){
                                $('.select2-room-meal-plan-complimentary').val(id);
                            } else {
                                $('.select2-room-meal-plan-complimentary').val('');
                            }
                            
                            $('.select2-room-meal-plan-complimentary').trigger('change');
}