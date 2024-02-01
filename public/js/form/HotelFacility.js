var FrmHotelFacilityPreference = function () {
    var facilityFormValidation = function () {
        var FrmHotelFacilityPreferenceForm = $('#FrmHotelFacility');
        var error4 = $('.error-message', FrmHotelFacilityPreferenceForm);
        var success4 = $('.error-message', FrmHotelFacilityPreferenceForm);

        FrmHotelFacilityPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: { required: true },
                type: { required: true },
                status: { required: true }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
                },
                type: {
                    required: $("select[name=type]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                } else if (element.attr("name") == "type") {
                    error.insertAfter("#type_id");
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
    var facilitiesFormValidation = function () {
        var FrmHotelFacilitiesPreferenceForm = $('#FrmHotelFacilities');
        var error4 = $('.error-message', FrmHotelFacilitiesPreferenceForm);
        var success4 = $('.error-message', FrmHotelFacilitiesPreferenceForm);

        FrmHotelFacilitiesPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: { required: true },              
                status: { required: true }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
                },                
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
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
    return {
        //main function to initiate the module
        init: function () {
            facilityFormValidation();
            facilitiesFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmHotelFacilityPreference.init();
});