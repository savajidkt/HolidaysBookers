var FrmCustomerPreference = function () {
    var CustomerFormValidation = function () {
        var FrmCustomerPreferenceForm = $('#FrmCustomer');
        var error4 = $('.error-message', FrmCustomerPreferenceForm);
        var success4 = $('.error-message', FrmCustomerPreferenceForm);

        FrmCustomerPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {

                first_name: { required: true },
                last_name: { required: true },
                dob: { required: true },
                country: { required: true },
                state: { required: true },
                city: { required: true },
                zipcode: { required: true },
                mobile_number: { required: true },
                email_address: { required: true, email: true },
                status: { required: true },
                password: {
                    required: function () {
                        if ($('.editPage').val() == 'no') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    minlength: 6,
                },
                confirm_password: {
                    required: function () {
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

                first_name: {
                    required: $("select[name=first_name]").attr('data-error')
                },
                last_name: {
                    required: $("input[name=last_name]").attr('data-error')
                },
                dob: {
                    required: $("input[name=dob]").attr('data-error')
                },
                country: {
                    required: $("select[name=country]").attr('data-error')
                },
                state: {
                    required: $("select[name=state]").attr('data-error')
                },
                city: {
                    required: $("select[name=city]").attr('data-error')
                },
                zipcode: {
                    required: $("input[name=zipcode]").attr('data-error')
                },
                mobile_number: {
                    required: $("input[name=mobile_number]").attr('data-error')
                },
                email_address: {
                    required: $("input[name=email_address]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
                password: {
                    required: $("input[name=password]").attr('data-error')
                },
                confirm_password: {
                    required: $("input[name=confirm_password]").attr('data-error')
                },

            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    var getStateList = function () {
        $(document).on('change', '#country', function () {
            var country_id = $(this).val();
            $('#state').find('option:not(:first)').remove();
            $('#city').find('option:not(:first)').remove();
            if (country_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $(".myState .spinner-border").show();
                    },
                    complete: function () {
                        $(".myState .spinner-border").hide();
                    },
                    type: 'POST',
                    url: moduleConfig.redirectUrl,
                    dataType: 'json',
                    data: {
                        country_id: country_id
                    },
                    success: function (data) {
                        if (data.status) {
                            $.each(data.states, function (key, val) {
                                $('#state').append(new Option(val.name, val.id));
                            });
                        }
                        $(".myState .spinner-border").hide();
                    }
                });
            }
        });
    }

    var getCityList = function () {
        $(document).on('change', '#state', function () {
            var state_id = $(this).val();
            $('#city').find('option:not(:first)').remove();
            if (state_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $(".myCity .spinner-border").show();
                    },
                    complete: function () {
                        $(".myCity .spinner-border").hide();
                    },
                    type: 'POST',
                    url: moduleConfig.getCities,
                    dataType: 'json',
                    data: {
                        state_id: state_id
                    },
                    success: function (data) {
                        if (data.status) {
                            $.each(data.cities, function (key, val) {
                                $('#city').append(new Option(val.name, val.id));
                            });
                        }
                        $(".myCity .spinner-border").hide();
                    }
                });
            }
        });
    }

    var changePasswordFormValidation = function () {
        var FrmChangePasswordPreferenceForm = $('#changePassword');
        var error4 = $('.error-message', FrmChangePasswordPreferenceForm);
        var success4 = $('.error-message', FrmChangePasswordPreferenceForm);

        FrmChangePasswordPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                },
                confirm_password: {
                    equalTo: "#password"
                },
            },
            messages: {
                password: {
                    required: $("input[name=password]").attr('data-error') + ' is required'
                },
                confirm_password: {
                    required: $("input[name=confirm_password]").attr('data-error') + ' is required'
                }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
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
            CustomerFormValidation();
            getStateList();
            getCityList();
            changePasswordFormValidation();

        }
    };
}();

$(document).ready(function () {
    FrmCustomerPreference.init();
    $(document).on('click', '.currntBTN', function () {
        $('#changePassword #modal_user_id').val($(this).data('user_id'));
        $('#ResetPasswordModal').modal('show');
    });

    $(document).on('click', '#DownloadCustomer', function () {
        var link = moduleConfig.fileUrl;
        var element = document.createElement('a');
        element.setAttribute('href', link);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    });

});