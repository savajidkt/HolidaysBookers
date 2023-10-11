var ClickBTN_Draft = false;
var ClickBTN_Quote = false;
var FrmCheckoutPreference = function () {
    var FrmCheckoutFormValidation = function () {
        var FrmCheckoutPreferenceForm = $('#CheckoutFrm');
        var error4 = $('.error-message', FrmCheckoutPreferenceForm);
        var success4 = $('.error-message', FrmCheckoutPreferenceForm);

        FrmCheckoutPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: ".ignore",
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
                    required: function () {
                        if (!ClickBTN_Draft) {
                            return true;
                        } else {
                            return false;
                        }
                    }
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

                var lead_passengers_country_code = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "lead_passengers_country_code").val($(".lead_passengers .phonenumber").intlTelInput("getSelectedCountryData").dialCode);

                var all_passengers_country_code = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "all_passengers_country_code").val($(".all_passengers .phonenumber").intlTelInput("getSelectedCountryData").dialCode);

                $('#CheckoutFrm').append(lead_passengers_country_code);
                $('#CheckoutFrm').append(all_passengers_country_code);

                if (ClickBTN_Quote) {
                    $("#saveQuotePopup").modal("show");
                } else {
                    form.submit();
                }

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
    $(document).on('click', '.saveDraft', function () {
        ClickBTN_Draft = true;
        $('.button_name_cls').val('');
        $('.button_name_cls').val('Draft');
        $('#CheckoutFrm').submit();
    });
    $(document).on('click', '.saveQuote', function () {
        ClickBTN_Draft = true;
        ClickBTN_Quote = true;
        $('.button_name_cls').val('');
        $('.button_name_cls').val('Quote');
        $('#CheckoutFrm').submit();
    });
    $(document).on('click', '.saveOrder', function () {
        ClickBTN_Draft = false;
        $('.button_name_cls').val('');
        $('.button_name_cls').val('Order');
        $('#CheckoutFrm').submit();
    });

    $(document).on('click', '#saveQuotePopup .quoteBtnClick', function () {

        $isValidChk = true;
        $isValidAmt = true;
        $isValidEmail = true;
        $isValidName = true;
        if (typeof $('.popup_margin_type:checked').val() === "undefined") {
            $('#popup_margin_type-error').removeClass('hide');
            $isValidChk = false;
        } else {

            $('#popup_margin_type-error').addClass('hide');
            $isValidChk = true;
        }

        if ($('.quote_email').val() == "") {
            $('#quote_email-error').removeClass('hide');
            $isValidEmail = false;

        } else {
            $('#quote_email-error').addClass('hide');
            $isValidEmail = true;
        }

        if ($('.margin_amt').val() == "") {
            $('#margin_amt-error').removeClass('hide');
            $isValidAmt = false;
        } else {

            $('#margin_amt-error').addClass('hide');
            $isValidAmt = true;
        }

        if ($('.quote_name').val() == "") {
            $('#quote_name-error').removeClass('hide');
            $isValidName = false;
        } else {

            $('#quote_name-error').addClass('hide');
            $isValidName = true;
        }

        //if ($isValidChk && $isValidAmt && $isValidEmail) {
        if ($isValidName) {
            ClickBTN_Quote = false;
            // $('.popup_margin_type_cls').val($('.popup_margin_type:checked').val());
            // $('.quote_email_cls').val($('.quote_email').val());
            // $('.margin_amt_cls').val($('.margin_amt').val());
            $('.quote_name_cls').val($('.quote_name').val());
            $('#CheckoutFrm').submit();
        } else {
            return false;
        }
    });

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
                // if (data.status) {
                //     window.location.replace(data.redirectURL);
                // }
                window.location.reload();
                $('.SelectRoomBook').closest('.SelectRoomBook').find('.fa-spin').hide();
                $('.SelectRoomBook').closest('.SelectRoomBook').find('.icon-arrow-top-right').show();
            }
        });
    });

    $(document).on('click', '.RemoveRoomBook', function () {
        $(this).closest('.RemoveRoomBook').find('.icon-trash').hide();
        $(this).closest('.RemoveRoomBook').find('.fa-spin').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            beforeSend: function () {

            },
            complete: function () {
                $('.RemoveRoomBook').closest('.RemoveRoomBook').find('.fa-spin').hide();
                $('.RemoveRoomBook').closest('.RemoveRoomBook').find('.icon-trash').show();
            },
            type: 'POST',
            url: moduleConfig.removeToCartBooking,
            dataType: 'json',
            data: {
                extra: $(this).attr('data-extra')
            },
            success: function (data) {
                // if (data.status) {
                //     window.location.replace(data.redirectURL);
                // }
                window.location.reload();
                $('.RemoveRoomBook').closest('.RemoveRoomBook').find('.fa-spin').hide();
                $('.RemoveRoomBook').closest('.RemoveRoomBook').find('.icon-trash').show();
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
    $('.lead_addvalidation').each(function () {

        $(this).rules("add", {
            required: true
        });

    });

    checkboxPassenger();

    $('.passengersEvent').change(function () {
        if ($(this).val() == "all") {
            $('.all_passengers').removeClass('hide');
            $('.lead_passengers').addClass('hide');
        } else {
            $('.lead_passengers').removeClass('hide');
            $('.all_passengers').addClass('hide');
        }
        checkboxPassenger();
    });

    function checkboxPassenger() {
        if ($('.passengersEvent:checked').val() == 'all') {
            $('.addvalidation, .lead_addvalidation').removeClass('ignore');
            $('.lead_addvalidation').addClass('ignore');
        } else {
            $('.addvalidation, .lead_addvalidation').removeClass('ignore');
            $('.addvalidation').addClass('ignore');
        }
    }



});