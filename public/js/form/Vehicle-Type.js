var FrmVehicleTypePreference = function () {
    var VehicleTypeFormValidation = function () {
        var FrmVehicleTypePreferenceForm = $('#FrmVehicleType');
        var error4 = $('.error-message', FrmVehicleTypePreferenceForm);
        var success4 = $('.error-message', FrmVehicleTypePreferenceForm);

        FrmVehicleTypePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                vehicle_name: { required: true },
                no_of_seats: { required: true },
                status: { required: true }
            },
            messages: {
                vehicle_name: {
                    required: $("input[name=vehicle_name]").attr('data-error')
                },
                no_of_seats: {
                    required: $("input[name=no_of_seats]").attr('data-error')
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
            VehicleTypeFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmVehicleTypePreference.init();
});