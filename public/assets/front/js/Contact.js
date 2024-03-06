var FrmContactPreference = function () {
    var FrmContactFormValidation = function () {
        var FrmContactPreferenceForm = $('#ContactFrm');
        var error4 = $('.error-message', FrmContactPreferenceForm);
        var success4 = $('.error-message', FrmContactPreferenceForm);

        FrmContactPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    required: true,
                },
                email: {
                    email: true,
                    customemail: true,
                    required: true,
                },
                phone: {
                    required: true,
                    phoneUS: true,
                },
                message: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: 'Full Name is required'
                },
                email: {
                    required: 'Email is required'
                },
                phone: {
                    required: 'Contact number is required'
                },
                message: {
                    required: 'Message is required'
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "name") {
                    error.insertAfter(".frmName");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".frmEmail");
                } else if (element.attr("name") == "phone") {
                    error.insertAfter(".frmPhone");
                } else if (element.attr("name") == "message") {
                    error.insertAfter(".frmMessage");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            FrmContactFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmContactPreference.init();

    $.validator.addMethod("customemail",
            function(value, element) {
                return this.optional(element) || /^[\w-\.]+@([\w-]+\.)+[\w-]{3}$/.test(value);
            },
            "Please enter a valid email address."
        );

    jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");

});