var FrmAgentPreference = function () {
    var AgentFormValidation = function () {
        var FrmAgentPreferenceForm = $('#FrmAgent');
        var error4 = $('.error-message', FrmAgentPreferenceForm);
        var success4 = $('.error-message', FrmAgentPreferenceForm);

        FrmAgentPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                agent_company_name: { required: true },
                agent_company_type: { required: true },
                nature_of_business: { required: true },
                agent_first_name: { required: true },
                agent_last_name: { required: true },
                agent_designation: { required: true },
                agent_dob: { required: true },
                agent_office_address: { required: true },
                agent_country: { required: true },
                agent_state: { required: true },
                agent_city: { required: true },
                agent_pincode: { required: true },
                agent_mobile_number: { required: true, digits: true },
                agent_telephone: { digits: true },
                agent_email: { required: true, email: true },
                agent_iata_number: {
                    required: function () {
                        if ($('input[name="agent_iata"]:checked').val() == 'yes') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                mgmt_first_name: { required: true },
                mgmt_last_name: { required: true },
                mgmt_contact_number: { required: true, digits: true },
                mgmt_email: { required: true, email: true },
                account_first_name: { required: true },
                account_last_name: { required: true },
                account_contact_number: { required: true, digits: true },
                account_email: { required: true, email: true },
                reserve_first_name: { required: true },
                reserve_last_name: { required: true },
                reserve_contact_number: { required: true, digits: true },
                reserve_email: { required: true, email: true },
                agent_username: { required: true },
                agent_password: {
                    required: function () {
                        if ($('.editPage').val() == 'no') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    minlength: 6,
                },
                agent_confirm_password: {
                    required: function () {
                        if ($('.editPage').val() == 'no') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    equalTo: "#agent_password"
                },
                status: { required: true }
            },
            messages: {
                agent_company_name: {
                    required: $("input[name=agent_company_name]").attr('data-error') + ' is required'
                },
                agent_company_type: {
                    required: $("select[name=agent_company_type]").attr('data-error') + ' is required'
                },
                nature_of_business: {
                    required: $("input[name=nature_of_business]").attr('data-error') + ' is required'
                },
                agent_first_name: {
                    required: $("input[name=agent_first_name]").attr('data-error') + ' is required'
                },
                agent_last_name: {
                    required: $("input[name=agent_last_name]").attr('data-error') + ' is required'
                },
                agent_designation: {
                    required: $("input[name=agent_designation]").attr('data-error') + ' is required'
                },
                agent_dob: {
                    required: $("input[name=agent_dob]").attr('data-error') + ' is required'
                },
                agent_office_address: {
                    required: $("input[name=agent_office_address]").attr('data-error') + ' is required'
                },
                agent_country: {
                    required: $("select[name=agent_country]").attr('data-error') + ' is required'
                },
                agent_state: {
                    required: $("select[name=agent_state]").attr('data-error') + ' is required'
                },
                agent_city: {
                    required: $("select[name=agent_city]").attr('data-error') + ' is required'
                },
                agent_pincode: {
                    required: $("input[name=agent_pincode]").attr('data-error') + ' is required'
                },
                agent_mobile_number: {
                    required: $("input[name=agent_mobile_number]").attr('data-error') + ' is required'
                },
                agent_email: {
                    required: $("input[name=agent_email]").attr('data-error') + ' is required'
                },
                agent_iata_number: {
                    required: $("input[name=agent_iata_number]").attr('data-error') + ' is required'
                },
                mgmt_first_name: {
                    required: $("input[name=mgmt_first_name]").attr('data-error') + ' is required'
                },
                mgmt_last_name: {
                    required: $("input[name=mgmt_last_name]").attr('data-error') + ' is required'
                },
                mgmt_contact_number: {
                    required: $("input[name=mgmt_contact_number]").attr('data-error') + ' is required'
                },
                mgmt_email: {
                    required: $("input[name=mgmt_email]").attr('data-error') + ' is required'
                },
                account_first_name: {
                    required: $("input[name=account_first_name]").attr('data-error') + ' is required'
                },
                account_last_name: {
                    required: $("input[name=account_last_name]").attr('data-error') + ' is required'
                },
                account_contact_number: {
                    required: $("input[name=account_contact_number]").attr('data-error') + ' is required'
                },
                account_email: {
                    required: $("input[name=account_email]").attr('data-error') + ' is required'
                },
                reserve_first_name: {
                    required: $("input[name=reserve_first_name]").attr('data-error') + ' is required'
                },
                reserve_last_name: {
                    required: $("input[name=reserve_last_name]").attr('data-error') + ' is required'
                },
                reserve_contact_number: {
                    required: $("input[name=reserve_contact_number]").attr('data-error') + ' is required'
                },
                reserve_email: {
                    required: $("input[name=reserve_email]").attr('data-error') + ' is required'
                },
                agent_username: {
                    required: $("input[name=agent_username]").attr('data-error') + ' is required'
                },
                agent_password: {
                    required: $("input[name=agent_password]").attr('data-error') + ' is required'
                },
                agent_confirm_password: {
                    required: $("input[name=agent_confirm_password]").attr('data-error') + ' is required'
                },
                status: {
                    required: $("select[name=status]").attr('data-error') + ' is required'
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
        $(document).on('change', '#agent_country', function () {
            var country_id = $(this).val();
            $('#agent_state').find('option:not(:first)').remove();
            $('#agent_city').find('option:not(:first)').remove();
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
                                $('#agent_state').append(new Option(val.name, val.id));
                            });
                        }
                        $(".myState .spinner-border").hide();
                    }
                });
            }
        });
    }

    var getCityList = function () {
        $(document).on('change', '#agent_state', function () {
            var state_id = $(this).val();
            $('#agent_city').find('option:not(:first)').remove();
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
                                $('#agent_city').append(new Option(val.name, val.id));
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

    var updateHBCreditFormValidation = function () {
        var FrmUpdateHBCreditPreferenceForm = $('#updateHBCredit');
        var error4 = $('.error-message', FrmUpdateHBCreditPreferenceForm);
        var success4 = $('.error-message', FrmUpdateHBCreditPreferenceForm);

        FrmUpdateHBCreditPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                type: {
                    required: true,
                },
                amount: {
                    required: true,
                    number: true
                },
                comment: {
                    required: true,
                },
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                var avilableBal = $('#HBCreditModal #HBCredit_Bal').val();
                var enterAmount = $('#HBCreditModal #amount').val();
                var enterType = $("#HBCreditModal select[name=type]").val();
                if (enterType == 0) {
                    if (parseFloat(avilableBal) < parseFloat(enterAmount)) {
                        Swal.fire({
                            title: 'Insufficient balance',
                            text: 'Please enter less then ₹' + avilableBal,
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                                cancelButton: 'btn btn-outline-danger ml-1'
                            },
                            buttonsStyling: false
                        });
                        return false;
                    }
                }
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            AgentFormValidation();
            getStateList();
            getCityList();
            changePasswordFormValidation();
            updateHBCreditFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmAgentPreference.init();


    $(document).on('click', '.currntBTN', function () {
        $('#changePassword #modal_user_id').val($(this).data('user_id'));
        $('#ResetPasswordModal').modal('show');
    });

    $(document).on('click', '.HBCredit', function () {
        $('#HBCreditModal #HBCredit_user_id').val($(this).data('user_id'));
        $('#HBCreditModal .agentName').html($(this).data('agent_code'));
        $('#HBCreditModal #availableBal').html('Avilable Balance ₹' + $(this).data('balance'));
        $('#HBCreditModal #HBCredit_Bal').val($(this).data('balance'));
        $('#HBCreditModal').modal('show');
    });


    $('input[type=radio][name=agent_iata]').change(function () {
        if (this.value == 'yes') {
            $('.iata_number_hide').removeClass('hide');
        }
        else {
            $('.iata_number_hide').addClass('hide');
        }
    });

    $('select[name=agent_know_about]').change(function () {
        var current = $('option:selected', this).attr('data-other');
        $('.otherData label').html('');
        if (current == '1') {
            $('.otherData label').html($('option:selected', this).attr('data-name'));
            $('.otherData').removeClass('hide');
        } else {
            $('.otherData').addClass('hide');
        }
    });


});