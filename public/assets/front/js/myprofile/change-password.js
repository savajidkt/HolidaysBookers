var FrmLoginPreference = function() {
    var FrmChangepasswordFormValidation = function() {
        var FrmLoginPreferenceForm = $('#change_password_form');
        var error4 = $('.error-message', FrmLoginPreferenceForm);
        var success4 = $('.error-message', FrmLoginPreferenceForm);
        FrmLoginPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                old_password: {
                    required: true,
                },
                new_password: {
                    minlength: 5,
                    required: true,
                },
                new_password_confirmation: {
                    minlength: 5,
                    equalTo: "#new_password",
                    required: true,
                },
            },
            messages: {},
            errorPlacement: function(error, element) {
                if (element.attr("name") == "old_password") {
                    error.insertAfter(".ferrorCls");
                } else if (element.attr("name") == "new_password") {
                    error.insertAfter(".lerrorCls");
                } else if (element.attr("name") == "new_password_confirmation") {
                    error.insertAfter(".eerrorCls");
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