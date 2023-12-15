var FrmPropertyTypePreference = function () {
    var PropertyTypeFormValidation = function () {
        var FrmPropertyTypePreferenceForm = $('#FrmPropertyType');
        var error4 = $('.error-message', FrmPropertyTypePreferenceForm);
        var success4 = $('.error-message', FrmPropertyTypePreferenceForm);

        FrmPropertyTypePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                property_name: { required: true },                
                status: { required: true }
            },
            messages: {
                property_name: {
                    required: $("input[name=property_name]").attr('data-error')
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
            PropertyTypeFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmPropertyTypePreference.init();
});