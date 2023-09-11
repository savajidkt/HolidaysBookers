var FrmLoginPreference = function() {
    var FrmChangepasswordFormValidation = function() {
        var FrmLoginPreferenceForm = $('#location_information');
        var error4 = $('.error-message', FrmLoginPreferenceForm);
        var success4 = $('.error-message', FrmLoginPreferenceForm);
        FrmLoginPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                address: {
                    required: true,
                },
                address2: {
                    required: true,
                },
                city: {
                    required: true,
                },
                state: {
                    required: true,
                },
                country: {
                    required: true,
                },
                zip_code: {
                    required: true,
                },
            },
            messages: {},
            errorPlacement: function(error, element) {
                if (element.attr("name") == "address") {
                    error.insertAfter(".ferrorCls");
                } else if (element.attr("name") == "address2") {
                    error.insertAfter(".lerrorCls");
                } else if (element.attr("name") == "city") {
                    error.insertAfter(".eerrorCls");
                } else if (element.attr("name") == "state") {
                    error.insertAfter(".stateCls");
                } else if (element.attr("name") == "country") {
                    error.insertAfter(".countryCls");
                } else if (element.attr("name") == "zip_code") {
                    error.insertAfter(".zipcodeCls");
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