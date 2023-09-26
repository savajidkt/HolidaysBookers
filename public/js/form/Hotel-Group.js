var FrmHotelGroupPreference = function() {
    var HotelGroupFormValidation = function() {
        var FrmHotelGroupPreferenceForm = $('#FrmHotelGroup');
        var error4 = $('.error-message', FrmHotelGroupPreferenceForm);
        var success4 = $('.error-message', FrmHotelGroupPreferenceForm);

        FrmHotelGroupPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                group_name: { required: true },
                status: { required: true }
            },
            messages: {
                group_name: {
                    required: $("input[name=group_name]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function(error, element) {

                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            HotelGroupFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmHotelGroupPreference.init();
});