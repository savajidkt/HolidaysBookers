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
                double_occupancy: {
                    required: function () {
                        if ($("input[name='price_type']:checked").val() != 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                single_occupancy: {
                    required: function () {
                        if ($("input[name='price_type']:checked").val() != 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                extra_pax_price: {
                    required: function () {
                        if ($("input[name='price_type']:checked").val() != 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            messages: {

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
            placeholder: "Select Freebies",
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
            FrmOfflineRoomPriceValidation();
            FrmEditOfflineRoomValidation();
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
