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
                // hotel_country: { required: true },
                // hotel_state: { required: true },
                // hotel_city: { required: true },
                category: { required: true },
                hotel_group_id: { required: true },
                phone_number: { required: true },
                hotel_address: { required: true },
                hotel_pincode: { required: true },
                hotel_email: { required: true },
                hotel_amenities: { required: true },
                property_type_id: { required: true },
                hotel_review: { required: true },
                hotel_latitude: { required: true },
                hotel_longitude: { required: true },
                cancel_days: { required: true }
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
                hotel_amenities: {
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
        $(document).on('change', '#hotel_state', function () {
            var state_id = $(this).val();
            $('#hotel_city').find('option:not(:first)').remove();
            if (state_id) {
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
                        state_id: state_id
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
            FrmAddAmenity();
            FrmAddGroup();
            FrmAddProperty();
            getStateList();
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
});