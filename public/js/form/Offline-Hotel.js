var FrmOfflineHotelPreference = function () {
    var FrmOfflineHotelValidation = function () {
        var FrmOfflineHotelPreferenceForm = $('#FrmOfflineHotel');
        var error4 = $('.error-message', FrmOfflineHotelPreference);
        var success4 = $('.error-message', FrmOfflineHotelPreference);

        FrmOfflineHotelPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_name: { required: true },
                 hotel_country: { required: true },
                // hotel_state: { required: true },
                 hotel_city: { required: true },
                category: { required: true },
                hotel_group_id: { required: true },
                phone_number: {required: true, digits: true },
                hotel_address: { required: true },
                hotel_pincode: { required: true },
                hotel_email: {required: true, email: true },
                'hotel_amenities[]': { required: true },
                property_type_id: { required: true },
                hotel_review: { required: true },
                hotel_latitude: { required: true },
                hotel_longitude: { required: true },
                cancel_days: { required: true },
                front_office_first_name: { required: true },
                front_office_designation: { required: true },
                front_office_contact_number: { required: true, digits: true },
                front_office_email: { required: true, email: true },
                sales_first_name: { required: true },
                sales_designation: { required: true },
                sales_contact_number: { required: true, digits: true },
                sales_email: { required: true, email: true},
                reservation_first_name: { required: true },
                reservation_designation: { required: true },
                reservation_contact_number: {required: true, digits: true },
                reservation_email: {required: true, email: true },
            },
            messages: {
                hotel_name: {
                    required: 'Hotel is required'
                },
                hotel_country: {
                    required: 'Country is required'
                },
                hotel_state: {
                    required: 'State is required'
                },
                hotel_city: {
                    required: 'City is required'
                },
                category: {
                    required: 'Category is required'
                },
                hotel_group_id: {
                    required: 'Group is required'
                },
                phone_number: {
                    required: 'Phone number is required'
                },
                hotel_address: {
                    required: 'Address is required'
                },
                hotel_pincode: {
                    required: 'Pincode is required'
                },
                hotel_email: {
                    required: 'Email is required'
                },
                'hotel_amenities[]': {
                    required: 'Amenity is required'
                },
                property_type_id: {
                    required: 'Property type is required'
                },
                hotel_review: {
                    required: 'Review is required'
                },
                hotel_latitude: {
                    required: 'Latitude is required'
                },
                hotel_longitude: {
                    required: 'Longitude is required'
                },
                cancel_days: {
                    required: 'Cancel day is required'
                },
                front_office_first_name: {
                    required: 'Front office name is required'
                },
                front_office_designation: {
                    required: 'Designation is required'
                },
                front_office_contact_number: {
                    required: 'Contact number is required'
                },
                front_office_email: {
                    required: 'Email is required'
                },
                sales_first_name: {
                    required: 'Sales name is required'
                },
                sales_designation: {
                    required: 'Sales designation is required'
                },
                sales_contact_number: {
                    required: 'Sales Contact number is required'
                },
                sales_email: {
                    required: 'Sales email is required'
                },
                reservation_first_name: {
                    required: 'Reservation name is required'
                },
                reservation_designation: {
                    required: 'Reservation designation is required'
                },
                reservation_contact_number: {
                    required: 'Reservation contact number is required'
                },
                reservation_email: {
                    required: 'Reservation email is required'
                },
            },
            submitHandler: function (form) {
                //$(".buttonLoader").removeClass('hide');
               

                var form_data = new FormData(form);

                var fileUpload = $('#mydropzone').get(0).dropzone;
                var files = fileUpload.files;


                for (var i = 0; i < files.length; i++) {
                    form_data.append(files[i].name, files[i]);
                    form_data.append("hotel_image[]", files[i]);
                }

                var fileUploadGallery = $('#hoteldropzone').get(0).dropzone;
                var filesGallery = fileUploadGallery.files;

                for (var i = 0; i < filesGallery.length; i++) {
                    form_data.append(filesGallery[i].name, filesGallery[i]);
                    form_data.append("hotel_gallery_image[]", filesGallery[i]);
                }

                $.ajax({
                    beforeSend: function () {

                    },
                    complete: function (data) {
                    },
                    error: function (data) {
                    },
                    type: "post",
                    url: moduleConfig.addStoreURL,
                    data: form_data,
                    dataType: 'json',
                    'global': false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        window.location = moduleConfig.indexURL;
                    },
                    error: function (x, t, m) {
                    }
                });

                // form.submit();
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
        $('.select2-hotel-amenities').val(HotelsAmenitiesIDs);
        $('.select2-hotel-amenities').trigger('change');
    }
    var OfflineHotelFreebies = function () {
        var selectFreebies = $('.select2-hotel-freebies');
        var hotelFreebiesData = [
            { id: '', text: '' }
        ];
        $.each(HotelsFreebies, function (key, val) {
            hotelFreebiesData.push({ id: key, text: val });
        });
        selectFreebies.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Freebies",
            allowClear: true,
            dropdownAutoWidth: true,
            dropdownParent: selectFreebies.parent(),
            width: '100%',
            data: hotelFreebiesData
        });
        $('.select2-hotel-freebies').val(HotelsFreebiesIDs);
        $('.select2-hotel-freebies').trigger('change');
    }

    var OfflineHotelGroups = function () {
        var selectGroups = $('#hotel_group_id');
        $(selectGroups).append($('<option>', {
            value: HotelsGroups.id,
            text: HotelsGroups.name
        }));

    }
    var OfflinePropertyType = function () {
        var selectProperty = $('#property_type_id');
        $(selectProperty).append($('<option>', {
            value: Property.id,
            text: Property.name
        }));

    }
    var getStateList = function () {
        $(document).on('change', '#hotel_country', function () {
            var country_id = $(this).val();
            $('#hotel_state').find('option:not(:first)').remove();
            $('#hotel_city').find('option:not(:first)').remove();
            if (country_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $(".myState .spinner-border").show();
                    },
                    complete: function () {
                        $(".myState .spinner-border").hide();
                    },
                    type: 'POST',
                    url: moduleConfig.redirectUrl,
                    dataType: 'json',
                    data: {
                        country_id: country_id
                    },
                    success: function (data) {
                        if (data.status) {
                            $.each(data.states, function (key, val) {
                                $('#hotel_state').append(new Option(val.name, val.id));
                            });
                        }
                        $(".myState .spinner-border").hide();
                    }
                });
            }
        });
    }

    var getCityList = function () {
        $(document).on('change', '#hotel_country', function () {
            var country_id = $(this).val();
            $('#hotel_city').find('option:not(:first)').remove();
            if (country_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $(".myCity .spinner-border").show();
                    },
                    complete: function () {
                        $(".myCity .spinner-border").hide();
                    },
                    type: 'POST',
                    url: moduleConfig.getCities,
                    dataType: 'json',
                    data: {
                        country_id: country_id
                    },
                    success: function (data) {
                        if (data.status) {
                            $.each(data.cities, function (key, val) {
                                $('#hotel_city').append(new Option(val.name, val.id));
                            });
                        }
                        $(".myCity .spinner-border").hide();
                    }
                });
            }
        });
    }

    var FrmAddFreebies = function () {
        var FrmHotelFreebiesPreferenceForm = $('#FrmhotelFreebies');
        var error4 = $('.error-message', FrmHotelFreebiesPreferenceForm);
        var success4 = $('.error-message', FrmHotelFreebiesPreferenceForm);

        FrmHotelFreebiesPreferenceForm.validate({
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
                        $("#FrmhotelFreebies .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmhotelFreebies .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addFreebiesURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            HotelsFreebies = data.responce;
                            //OfflineHotelFreebies();
                            var datas = [];
                            $.each(HotelsFreebies, function (key, val) {
                                datas.push({
                                    id: key,
                                    text: val
                                });
                            });
                            $(".select2-hotel-freebies").select2({
                                data: datas
                            });
                            $('#freebiesBTN').modal('hide');
                        }
                        $("#FrmhotelFreebies .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }

    var FrmAddAmenity = function () {
        var FrmHotelAmenityPreferenceForm = $('#FrmhotelAmenity');
        var error4 = $('.error-message', FrmHotelAmenityPreferenceForm);
        var success4 = $('.error-message', FrmHotelAmenityPreferenceForm);

        FrmHotelAmenityPreferenceForm.validate({
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
                        $("#FrmhotelAmenity .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmhotelAmenity .buttonLoader").addClass('hide');
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
                        $("#FrmhotelAmenity .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }
    var FrmAddGroup = function () {
        var FrmHotelGroupPreferenceForm = $('#FrmhotelGroup');
        var error4 = $('.error-message', FrmHotelGroupPreferenceForm);
        var success4 = $('.error-message', FrmHotelGroupPreferenceForm);

        FrmHotelGroupPreferenceForm.validate({
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
                        $("#FrmhotelGroup .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmhotelGroup .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addGroupURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            HotelsGroups = data.responce;
                            OfflineHotelGroups();
                            $('#HotelGroupPopup').modal('hide');
                        }
                        $("#FrmhotelGroup .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }
    var FrmAddProperty = function () {
        var FrmPropertyPreferenceForm = $('#FrmPropertyType');
        var error4 = $('.error-message', FrmPropertyPreferenceForm);
        var success4 = $('.error-message', FrmPropertyPreferenceForm);

        FrmPropertyPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                property_name: {
                    required: true,
                }
            },
            messages: {
                property_name: {
                    required: $("input[name=property_name]").attr('data-error')
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
                        $("#FrmPropertyType .buttonLoader").removeClass('hide');
                    },
                    complete: function () {
                        $("#FrmPropertyType .buttonLoader").addClass('hide');
                    },
                    type: 'POST',
                    url: moduleConfig.addPropertyURL,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        if (data.status) {
                            Property = data.responce;
                            OfflinePropertyType();
                            $('#PropertyPopup').modal('hide');
                        }
                        $("#FrmPropertyType .buttonLoader").addClass('hide');
                    }
                });
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            FrmOfflineHotelValidation();
            OfflineHotelAmenities();
            OfflineHotelFreebies();
            FrmAddAmenity();
            FrmAddFreebies();
            FrmAddGroup();
            FrmAddProperty();
            //getStateList();
            getCityList();
        }
    };
}();

$(document).ready(function () {
    FrmOfflineHotelPreference.init();
    $(document).on('click', '.HotelGroupPopup', function () {
        $('#HotelGroupPopup').modal('show');
    });

    $(document).on('click', '.PropertyPopup', function () {
        $('#PropertyPopup').modal('show');
    });
    $(document).on('click', '.roomAmenityBTN', function () {
        $('#roomAmenityBTN').modal('show');
    });
    $(document).on('click', '.freebiesBTN', function () {
        $('#freebiesBTN').modal('show');
    });
});