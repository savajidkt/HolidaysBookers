var FrmLoginPreference = function () {
    var FrmLoginFormValidation = function () {
        var FrmLoginPreferenceForm = $('#loginFrm');
        var error4 = $('.error-message', FrmLoginPreferenceForm);
        var success4 = $('.error-message', FrmLoginPreferenceForm);
        FrmLoginPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    email: true,
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "email") {
                    error.insertAfter(".emailDiv");
                } else if (element.attr("name") == "password") {
                    error.insertAfter(".passwordDiv");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
    var FrmRegisterFormValidation = function () {
        var FrmLoginPreferenceForm = $('#RegisterFrm');
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
                password: {
                    minlength: 5,
                    required: true,
                },
                password_confirmation: {
                    minlength: 5,
                    equalTo: "#password",
                    required: true,
                },
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "first_name") {
                    error.insertAfter(".ferrorCls");
                } else if (element.attr("name") == "last_name") {
                    error.insertAfter(".lerrorCls");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".eerrorCls");
                } else if (element.attr("name") == "password") {
                    error.insertAfter(".perrorCls");
                } else if (element.attr("name") == "password_confirmation") {
                    error.insertAfter(".pcerrorCls");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }
    var FrmForgotFormValidation = function () {
        var FrmForgotPreferenceForm = $('#ForgotFrm');
        var error4 = $('.error-message', FrmForgotPreferenceForm);
        var success4 = $('.error-message', FrmForgotPreferenceForm);
        FrmForgotPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    email: true,
                    required: true,
                }
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "email") {
                    error.insertAfter(".emailDiv");
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
            FrmLoginFormValidation();
            FrmRegisterFormValidation();
            FrmForgotFormValidation();
        }
    };
}();

$(document).ready(function () {
    // Swal.fire({
    //     toast: true,
    //     icon: 'success',
    //     title: 'Posteddddddd successfully',
    //     animation: true,
    //     position: 'top-right',
    //     showConfirmButton: false,
    //     timer: 3000,
    //     timerProgressBar: true,
    //     didOpen: (toast) => {
    //       toast.addEventListener('mouseenter', Swal.stopTimer)
    //       toast.addEventListener('mouseleave', Swal.resumeTimer)
    //     }
    //   })

    FrmLoginPreference.init();
});