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
                lead_name: {
                    required: true,
                },
                lead_surname: {
                    required: true,
                },                
                agency_reference: {
                    required: true,
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
                if (element.attr("name") == "agree") {
                    error.insertAfter(".agree");
                } else if (element.attr("name") == "payment_method") {
                    error.insertAfter(".payment_methodcls");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
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
                    emailExt: true
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
            FrmCheckoutLoginFormValidation();

            jQuery.validator.addMethod("emailExt", function(value, element, param) {

                return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);

            }, 'Please enter a valid email address.');

        }
    };
}();

$(document).ready(function () {
    FrmCheckoutPreference.init();

    $(document).on('click', '.removeHotel', function () {


        var hotel_id = $(this).attr('data-hotel-id');
        var hotel_room_id = $(this).attr('data-hotel-room-id');
        var key_id = $(this).attr('data-cart-key');
        swal({
            title: "Are you sure?",
            text: "You won't be remove this!",
            icon: "warning",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3554d1",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"

        },
            function (resp) {
                if (resp) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        beforeSend: function () {
                            $('body').block({ message: null });
                        },
                        complete: function () {
                            $('body').unblock();
                        },
                        type: 'POST',
                        url: moduleConfig.removeHotel,
                        dataType: 'json',
                        data: {
                            hotel_id: hotel_id,
                            hotel_room_id: hotel_room_id,
                            key_id: key_id
                        },
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                }
            }
        );
    });

    $(document).on('click', '.removeCart', function () {


        swal({
            title: "Are you sure?",
            text: "You won't be remove cart!",
            icon: "warning",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3554d1",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"

        },
            function (resp) {
                if (resp) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        beforeSend: function () {
                            $('body').block({ message: null });
                        },
                        complete: function () {
                            $('body').unblock();
                        },
                        type: 'GET',
                        url: moduleConfig.removeCart,
                        dataType: 'json',
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                }
            }
        );
    });

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

            var quote_name = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "quote_name").val($('.quote_name').val());             

                $('#CheckoutFrm').append(quote_name);
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