var FrmLoginPreference = function() {
    var FrmChangepasswordFormValidation = function() {
        var FrmLoginPreferenceForm = $('#personal_information');
        var error4 = $('.error-message', FrmLoginPreferenceForm);
        var success4 = $('.error-message', FrmLoginPreferenceForm);
        FrmLoginPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    email: true,
                    required: true,
                },
                phone_number: {
                    required: true,
                },
            },
            messages: {},
            errorPlacement: function(error, element) {
                if (element.attr("name") == "first_name") {
                    error.insertAfter(".ferrorCls");
                } else if (element.attr("name") == "last_name") {
                    error.insertAfter(".lerrorCls");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".eerrorCls");
                } else if (element.attr("name") == "phone_number") {
                    error.insertAfter(".phoneCls");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {

                form.submit();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            FrmChangepasswordFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmLoginPreference.init();
});