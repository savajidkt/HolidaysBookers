var FrmQuotePreference = function() {



    var FrmQuoteomplete = function() {



        var FrmSearchPreferenceForm = $('#QuoteFrm');

        var error4 = $('.error-message', FrmSearchPreferenceForm);

        var success4 = $('.error-message', FrmSearchPreferenceForm);



        FrmSearchPreferenceForm.validate({

            errorElement: 'span',

            errorClass: 'help-block help-block-error',

            focusInvalid: false,

            ignore: "",

            rules: {

                emails: {

                    required: true,
                    email: true,
                    emailExt: true

                },

                senderemail: {

                    required: true,

                },

                subject: {

                    required: true,

                },

                reviews: {

                    required: true,

                },

            },

            errorPlacement: function(error, element) {

                if (element.attr("name") == "emails") {

                    error.insertAfter(".frmEmails");

                } else if (element.attr("name") == "senderemail") {

                    error.insertAfter(".frmSenderemail");

                } else if (element.attr("name") == "subject") {

                    error.insertAfter(".frmSubject");

                } else if (element.attr("name") == "reviews") {

                    error.insertAfter(".frmMessage");

                } else {

                    error.insertAfter(element);

                }

            },

            submitHandler: function(form) {

                form.submit();

            }

        });

    }



    var FrmQuoteEditPrice = function() {



        var FrmSearchPreferenceForm = $('#EditPriceFrm');

        var error4 = $('.error-message', FrmSearchPreferenceForm);

        var success4 = $('.error-message', FrmSearchPreferenceForm);



        FrmSearchPreferenceForm.validate({

            errorElement: 'span',

            errorClass: 'help-block help-block-error',

            focusInvalid: false,

            ignore: "",

            rules: {

                extra_markup_price: {

                    required: false,

                }

            },

            errorPlacement: function(error, element) {

                if (element.attr("name") == "extra_markup_price") {

                    error.insertAfter(".extra_markup_price-error");

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

            FrmQuoteomplete();

            FrmQuoteEditPrice();

            jQuery.validator.addMethod("emailExt", function(value, element, param) {

                return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);

            }, 'Please enter a valid email address.');

        }

    };

}();



$(document).ready(function() {

    FrmQuotePreference.init();



    $(document).on('click', '.QuoteRoomEdit', function() {

        $('.cName').html($(this).attr('data-room-name'));

        $('.pvpInput').val($(this).attr('data-room-price'));

        $('.extra_markup_price').attr('data-c-p', $(this).attr('data-price'))

        $('.extra_markup_price').attr('data-cy-p', $(this).attr('data-cy-price'))

        var finalPrice = parseFloat($(this).attr('data-price')) + parseFloat($(this).attr('data-markup-price'));

        $('.final_markup_price').val($(this).attr('data-cy-price') + '' + finalPrice);

        $('.room_id').val($(this).attr('data-room-id'));

        $('.order_id').val($(this).attr('data-order-id'));

        $('.extra_markup_price').val($(this).attr('data-markup-price'));

        $("#editRoomPrice").modal("show");

    });



    $(".close").click(function() {

        $(".modal").modal('hide');

    });



    $(".extra_markup_price").keyup(function() {

        var newInput = $(this).val();

        var oldInput = $(this).attr('data-c-p');

        var cy = $(this).attr('data-cy-p');

        var final = parseFloat(oldInput);

        if (newInput > 0 && newInput != "") {

            final = parseFloat(newInput) + parseFloat(oldInput);

        }

        $('.final_markup_price').val('');

        $('.final_markup_price').val(cy + ' ' + final.toFixed(2));

    });



});