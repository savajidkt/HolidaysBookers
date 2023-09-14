var FrmCustomerPreference = function() {
    var CustomerFormValidation = function() {
        var FrmCustomerPreferenceForm = $('#jquery-val-form');
        var error4 = $('.error-message', FrmCustomerPreferenceForm);
        var success4 = $('.error-message', FrmCustomerPreferenceForm);

        FrmCustomerPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {

                fullname: { required: true },
                email: { required: true, email: true, emailExt: true },
                role: { required: true },
                password: {
                    required: function() {
                        if ($('.editPage').val() == 'no') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    minlength: 6,
                },
                confirm_password: {
                    required: function() {
                        if ($('.editPage').val() == 'no') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    equalTo: "#password"
                },

            },
            messages: {

                fullname: {
                    required: $("input[name=first_name]").attr('data-error')
                },
                email: {
                    required: $("input[name=email]").attr('data-error')
                },
                role: {
                    required: $("select[name=role]").attr('data-error')
                },
                password: {
                    required: $("input[name=password]").attr('data-error')
                },
                confirm_password: {
                    required: $("input[name=confirm_password]").attr('data-error')
                },

            },
            errorPlacement: function(error, element) {

                if (element.attr("name") == "country") {
                    error.insertAfter("#country_id");
                } else if (element.attr("name") == "state") {
                    error.insertAfter("#state_id");
                } else if (element.attr("name") == "city") {
                    error.insertAfter("#city_id");
                } else if (element.attr("name") == "status") {
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
            CustomerFormValidation();

            jQuery.validator.addMethod("emailExt", function(value, element, param) {
                return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);
            }, 'Please enter a valid email address.');

        }
    };
}();

$(document).ready(function() {
    FrmCustomerPreference.init();
    $(document).on('click', '.currntBTN', function() {
        $('#changePassword #modal_user_id').val($(this).data('user_id'));
        $('#ResetPasswordModal').modal('show');
    });

    $(document).on('click', '#DownloadCustomer', function() {
        var link = moduleConfig.fileUrl;
        var element = document.createElement('a');
        element.setAttribute('href', link);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    });

});