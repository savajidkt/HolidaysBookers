var FrmCheckoutPreference = function () {
    var FrmCheckoutFormValidation = function () {
        var FrmCheckoutPreferenceForm = $('#CheckoutFrm');
        var error4 = $('.error-message', FrmCheckoutPreferenceForm);
        var success4 = $('.error-message', FrmCheckoutPreferenceForm);

        FrmCheckoutPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                email: {
                    email: true,
                    required: true,
                },
                phone: {
                    required: true,
                },
                registration_number: {
                    required: function () {
                        if ($('input[name="gst_enable"]').is(':checked')) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                registered_company_name: {
                    required: function () {
                        if ($('input[name="gst_enable"]').is(':checked')) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                registered_company_address: {
                    required: function () {
                        if ($('input[name="gst_enable"]').is(':checked')) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                agree: {
                    required: true,
                },
                payment_method: {
                    required: true,
                }             
            },
            messages: {

            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "firstname") {
                    error.insertAfter(".firstname");
                } else if (element.attr("name") == "lastname") {
                    error.insertAfter(".lastname");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".email");
                } else if (element.attr("name") == "phone") {
                    error.insertAfter(".phone");
                } else if (element.attr("name") == "registration_number") {
                    error.insertAfter(".registration_number");
                } else if (element.attr("name") == "registered_company_name") {
                    error.insertAfter(".registered_company_name");
                } else if (element.attr("name") == "registered_company_address") {
                    error.insertAfter(".registered_company_address");
                } else if (element.attr("name") == "agree") {
                    error.insertAfter(".agree");
                } else if (element.attr("name") == "payment_method") {
                    error.insertAfter(".payment_methodcls");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    var FrmCheckoutLoginFormValidation = function () {
        var FrmCheckoutPreferenceForm = $('#loginFrm');
        var error4 = $('.error-message', FrmCheckoutPreferenceForm);
        var success4 = $('.error-message', FrmCheckoutPreferenceForm);

        FrmCheckoutPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
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
                    error.insertAfter(".email-error");
                } else if (element.attr("name") == "password") {
                    error.insertAfter(".password-error");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {


                $('.SelectSignin').find('.icon-arrow-top-right').hide();
                $('.SelectSignin').find('.fa-spin').show();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        //$(this).closest('.SelectRoomBook').find('.icon-arrow-top-right').hide();
                        // $(this).closest('.SelectRoomBook').find('.fa-spin').show();
                    },
                    complete: function () {
                        $('.SelectSignin').find('.fa-spin').hide();
                        $('.SelectSignin').find('.icon-arrow-top-right').show();
                    },
                    type: 'POST',
                    url: moduleConfig.checkoutLogin,
                    dataType: 'json',
                    data: {
                        email: $('.emailInput').val(),
                        password: $('.passwordInput').val(),
                        redirect: $('.redirect').val(),
                    },
                    success: function (data) {
                        var string = "";
                        if (data.status) {
                            string = `<div class="col-12">
                            <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                  <div class="text-success-2 lh-1 fw-500">`+ data.message + `</div>
                  
                </div>
                          </div>`;
                          window.location.reload();
                        } else {
                            string = `<div class="col-12">
                            <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                              <div class="text-error-2 lh-1 fw-500">`+ data.message + `</div>
                             
                            </div>
                          </div>`;
                        }
                        $('.display-message').after(string);
                    }
                });
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            FrmCheckoutFormValidation();
            FrmCheckoutLoginFormValidation()

        }
    };
}();

$(document).ready(function () {
    FrmCheckoutPreference.init();
    $(document).on('click', '.SelectRoomBook', function () {
        $(this).closest('.SelectRoomBook').find('.icon-arrow-top-right').hide();
        $(this).closest('.SelectRoomBook').find('.fa-spin').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            beforeSend: function () {
                //$(this).closest('.SelectRoomBook').find('.icon-arrow-top-right').hide();
                // $(this).closest('.SelectRoomBook').find('.fa-spin').show();
            },
            complete: function () {
                $('.SelectRoomBook').closest('.SelectRoomBook').find('.fa-spin').hide();
                $('.SelectRoomBook').closest('.SelectRoomBook').find('.icon-arrow-top-right').show();
            },
            type: 'POST',
            url: moduleConfig.addedToCartBooking,
            dataType: 'json',
            data: {
                extra: $(this).attr('data-extra')
            },
            success: function (data) {
                if (data.status) {
                    window.location.replace(data.redirectURL);
                }
                $('.SelectRoomBook').closest('.SelectRoomBook').find('.fa-spin').hide();
                $('.SelectRoomBook').closest('.SelectRoomBook').find('.icon-arrow-top-right').show();
            }
        });


    });

    $('input[name="gst_enable"]').change(function () {
        if ($(this).is(':checked')) {
            $('.enablegst').removeClass('hide');
        } else {
            $('.enablegst').addClass('hide');
        }
    });

    $('.addvalidation').each(function () {
        $(this).rules("add", {
            required: true
            });
           
    });    

});