var MySearchArr = [];


var FrmSearchPreference = function () {
    var FrmSearchFormValidation = function () {
        var FrmSearchPreferenceForm = $('#SearchFrm');
        var error4 = $('.error-message', FrmSearchPreferenceForm);
        var success4 = $('.error-message', FrmSearchPreferenceForm);

        FrmSearchPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                location: {
                    required: true,
                },
                search_to: {
                    required: function () {
                        if ($('#hidden_to').val() == "" || $('#hidden_from').val() == "") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
            },
            messages: {
                location: {
                    required: 'Location is required!'
                },
                search_to: {
                    required: 'Check in - Check out is required!'
                }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {

                createCookie('location', JSON.stringify($('#location').val()), 1);
                createCookie('hidden_city_id', JSON.stringify($('.hidden_city_id').val()), 1);
                createCookie('hidden_hotel_id', JSON.stringify($('.hidden_hotel_id').val()), 1);
                createCookie('country_id', JSON.stringify($('.hidden_country_id').val()), 1);
                createCookie('search_from', JSON.stringify($('#hidden_from').val()), 1);
                createCookie('search_to', JSON.stringify($('#hidden_to').val()), 1);

                form.submit();
            }
        });
    }
    var FrmAutocomplete = function () {

        $("#location").autocomplete({
            source: function (request, response) {

                MySearchArr['city'] = [];
                MySearchArr['hotel'] = [];

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: moduleConfig.searchLocationByName,
                    type: "POST",
                    dataType: "json",
                    async: false,
                    cache: false,
                    data: {
                        search: request.term
                    },
                    success: function (data) {
                        if (data.status) {
                            MySearchArr['city'] = data.data;
                            MySearchArr['hotel'] = data.hotelData;
                            liveSearches();
                        }
                    }
                });
            },

            minLength: 2,
            select: function (event, ui) { },
            open: function () {
                console.log('open');
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                console.log('close');
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
    }

    var FrmCheckoutLoginAuthFormValidation = function () {
        var FrmCheckoutPreferenceForm = $('#searchloginFrm');
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

                $('.messageError').remove();

                $('.SelectSignin').find('.icon-arrow-top-right').hide();
                $('.SelectSignin').find('.fa-spin').show();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () { },
                    complete: function () {
                        $('.SelectSignin').find('.fa-spin').hide();
                        $('.SelectSignin').find('.icon-arrow-top-right').show();
                    },
                    type: 'POST',
                    url: moduleConfig.userLoginAuthLogin,
                    dataType: 'json',
                    data: {
                        email: $('.emailInput').val(),
                        password: $('.passwordInput').val()
                    },
                    success: function (data) {
                        var string = "";
                        if (data.status) {
                            string = `<div class="col-12 messageError">
                            <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                  <div class="text-success-2 lh-1 fw-500">`+ data.message + `</div>
                  </div>
                          </div>`;
                            window.location.reload();
                        } else {
                            string = `<div class="col-12 messageError">
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

    var FrmCheckoutRegisterAuthFormValidation = function () {
        var FrmCheckoutPreferenceForm = $('#searchRegisterFrm');
        var error4 = $('.error-message', FrmCheckoutPreferenceForm);
        var success4 = $('.error-message', FrmCheckoutPreferenceForm);

        FrmCheckoutPreferenceForm.validate({
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
                    required: true,
                },
                type: {
                    required: true,
                },
                password: {
                    required: true,
                },
                term: {
                    required: true,
                },
            },
            messages: {

            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "first_name") {
                    error.insertAfter(".error-first_name");
                } else if (element.attr("name") == "last_name") {
                    error.insertAfter(".error-last_name");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".error-email");
                } else if (element.attr("name") == "type") {
                    error.insertAfter(".error-type");
                } else if (element.attr("name") == "password") {
                    error.insertAfter(".error-password");
                } else if (element.attr("name") == "password_confirmation") {
                    error.insertAfter(".error-confirmation-password");
                } else if (element.attr("name") == "term") {
                    error.insertAfter(".error-term");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {

                $('.messageError').remove();

                $('.SelectSignin').find('.icon-arrow-top-right').hide();
                $('.SelectSignin').find('.fa-spin').show();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () { },
                    complete: function () {
                        $('.SelectSignin').find('.fa-spin').hide();
                        $('.SelectSignin').find('.icon-arrow-top-right').show();
                    },
                    type: 'POST',
                    url: moduleConfig.userCreateAuthLogin,
                    dataType: 'json',
                    data: $(form).serialize(),
                    success: function (data) {
                        var string = "";
                        if (data.validation) {
                            if (data.email) {
                                string = `<div class="col-12 messageError">
                            <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                              <div class="text-error-2 lh-1 fw-500">`+ data.email + `</div>                             
                            </div>
                          </div>`;
                            } else if (data.password) {
                                string = `<div class="col-12 messageError">
                                <div class="d-flex items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                                  <div class="text-error-2 lh-1 fw-500">`+ data.password + `</div>                             
                                </div>
                              </div>`;
                            }

                        } else if (data.status) {

                            string = `<div class="col-12 messageError">
                            <div class="d-flex items-center justify-between bg-success-1 pl-30 pr-20 py-30 rounded-8">
                  <div class="text-success-2 lh-1 fw-500">`+ data.message + `</div>
                  </div>
                          </div>`;
                            window.location.reload();

                        } else {
                            string = `<div class="col-12 messageError">
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
            FrmSearchFormValidation();
            FrmAutocomplete();
            FrmAddMoreGuest();
            FrmCheckoutLoginAuthFormValidation();
            FrmCheckoutRegisterAuthFormValidation();
        }
    };
}();

function changeDatepickerLocation() {
    $(".daterangepicker.ltr.show-calendar").appendTo(".masthead__tabs.is-in-view");
}
window.addEventListener("load", function () {
    setTimeout(changeDatepickerLocation, 500);
});

// function changeDatepickerLocation() {
//     $(".daterangepicker.ltr.show-calendar").appendTo(".mainSearch");
// }
// window.addEventListener("load", function () {
//     setTimeout(changeDatepickerLocation, 500);
// });

$(document).ready(function () {


    FrmSearchPreference.init();


    $(document).on('click', '.priceBreakup', function () {
        $('.CustomPriceDetails').removeClass('is-hidden');
    });


    $(document).on('click', '.SelectRoomBook', function () {

        $(this).closest('.SelectRoomBook').find('.icon-arrow-top-right').hide();
        $(this).closest('.SelectRoomBook').find('.fa-spin').show();

        $(this).addClass('ClickTome');

        var currentBTN = $(this);
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
                    swal({
                        title: "",
                        text: "Added to cart successfully",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Process to checkout',
                        cancelButtonText: "Continue shopping",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                        function (resp) {
                            if (resp) {
                                window.location = data.redirectURL;
                            } else {
                                //$('.ClickTome span').html('Added');
                                //$('.ClickTome div').remove();
                                //currentBTN.removeAttr('data-extra');
                                //currentBTN.removeClass('SelectRoomBook');                             
                                //currentBTN.removeClass('ClickTome'); 

                                $('#lblCartCount').html('');
                                $('#lblCartCount').html(data.cartItem);

                                swal.close();
                            }
                        });
                } else {

                    swal({
                        title: "",
                        text: "Added to cart failed",
                        type: "error",
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'OK',
                        closeOnConfirm: true
                    },
                        function (resp) {
                            if (resp) {
                                window.location.reload();
                            }
                        });

                }
                //window.location.reload();
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
                swal({
                    title: "",
                    text: "Remove to cart successfully",
                    type: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
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
                //window.location.reload();
                $('.RemoveRoomBook').closest('.RemoveRoomBook').find('.fa-spin').hide();
                $('.RemoveRoomBook').closest('.RemoveRoomBook').find('.icon-trash').show();
            }
        });
    });


    var daterange_transfer_returns = check_in_startDate;
    $(function () {
        $('input[name="daterange"]').daterangepicker({
            startDate: check_in_startDate,
            endDate: check_in_endDate,
            opens: 'left',
            minDate: new Date(),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {
            $('#hidden_from').val(start.format('YYYY-MM-DD'));
            $('#hidden_to').val(end.format('YYYY-MM-DD'));
        });

        $('input[name="daterange_transfer_departure"]').daterangepicker({
            singleDatePicker: true,
            opens: 'left',
            minDate: new Date()
        }, function (start, end, label) {
            daterange_transfer_returns = start.format('MM-DD-YYYY');
            $('#daterange_transfer_departure_from').val(start.format('YYYY-MM-DD'));
        });
        $('input[name="daterange_transfer_return"]').daterangepicker({
            startDate: daterange_transfer_returns,
            singleDatePicker: true,
            opens: 'left',
            minDate: new Date()
        }, function (start, end, label) {
            $('#daterange_transfer_return').val(start.format('YYYY-MM-DD'));
        });
    });

    $(document).on('change', '.childMore', function () {
        var totalChild = this.attributes['data-child'].value;
        var selectedChild = $('option:selected', this).val();
        var unSelectedChild = parseInt(totalChild) - parseInt(selectedChild);
        if (this.id == "child_age_younger") {
            $('#child_age_younger').val(selectedChild);
            $('#child_age_older').val(unSelectedChild);
        } else if (this.id == "child_age_older") {
            $('#child_age_older').val(selectedChild);
            $('#child_age_younger').val(unSelectedChild);
        } else {
            $('#child_age_older').val('0');
            $('#child_age_younger').val('0');
        }
    });

    $(document).on('click', '.viewMoreRooms', function () {

        var hotel_id = $(this).attr('data-hotel-id');
        var type = $(this).attr('data-type');

        if (type == "see") {
            if ($('.slide-out-div-' + hotel_id).is(":hidden")) {
                $('.images-' + hotel_id).slideUp('slow');
                $('.map-' + hotel_id).slideUp('slow');
                $('.description-' + hotel_id).slideUp('slow');
                getAllRoomslList(hotel_id);
            } else {
                $('.slide-out-div-' + hotel_id).slideUp('slow');
            }
        } else if (type == "map") {
            if ($('.map-' + hotel_id).is(":hidden")) {
                $('.map-' + hotel_id).slideDown('slow');
                $('.map-' + hotel_id).removeClass('is-hide');

                $('.slide-out-div-' + hotel_id).slideUp('slow');
                $('.images-' + hotel_id).slideUp('slow');
                $('.description-' + hotel_id).slideUp('slow');
            } else {
                $('.map-' + hotel_id).slideUp('slow');
            }
        } else if (type == "images") {
            if ($('.images-' + hotel_id).is(":hidden")) {
                $('.images-' + hotel_id).slideDown('slow');
                $('.images-' + hotel_id).removeClass('is-hide');

                $('.slide-out-div-' + hotel_id).slideUp('slow');
                $('.map-' + hotel_id).slideUp('slow');
                $('.description-' + hotel_id).slideUp('slow');

            } else {
                $('.images-' + hotel_id).slideUp('slow');
            }
        } else if (type == "description") {
            if ($('.description-' + hotel_id).is(":hidden")) {
                $('.description-' + hotel_id).slideDown('slow');
                $('.description-' + hotel_id).removeClass('is-hide');

                $('.slide-out-div-' + hotel_id).slideUp('slow');
                $('.map-' + hotel_id).slideUp('slow');
                $('.images-' + hotel_id).slideUp('slow');

            } else {
                $('.description-' + hotel_id).slideUp('slow');
            }
        }
    });

    $('.round-trip').on('change.bootstrapSwitch', function (e) {
        if (e.target.checked == true) {
            $('.transfer_return_round').show();
        } else {
            $('.transfer_return_round').hide();
        }
    });

    $(".daterangepicker.ltr.show-calendar").appendTo(".masthead__tabs.is-in-view");

});

var createCookie = function (cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

var readCookie = function (cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function FrmAddMoreGuest() {

    $(document).on('click', '.addMore', function () {
        var numbers = $('.optionBox:last').find('.roomNumber').html();
        var totalNub = parseInt(numbers) + parseInt(1);
        var moreSting = `<div class="row optionBox">
        <div class="col-lg-6 ddynamicChilds">
            <div class="col-lg-2  py-20">
                <div class="accordion__icon size-40 flex-center bg-error-1 rounded-full mr-20 remove"
                    data-action="remove">
                    <i class="icon-minus"></i>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="fw-500 mb-4">Room</div>
                <div class="">
                    <label class="lh-1 text-16 fw-500 text-dark-1 roomNumber">`+ totalNub + `</label>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Adult</label>
                <select name="adult" id="adult" class="adult text-center">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="col-lg-3 text-center">
                <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Child</label>
                <select name="child" id="child" class="addDynamicChilds text-center child" data-old-c="0">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>
        <div class="dynamicChilds col-lg-6 text-center">                              
        </div>
        <hr>
    </div>
    `;
        $('.row-block:last').before(moreSting);
    });

    jQuery(document).on('click', '.remove', function () {
        var numbers = $(this).closest('.optionBox').find('.roomNumber').html();
        $(this).closest('.optionBox').remove();
        changeNumber();
    });

    jQuery(document).on('click', '.SearchDone', function () {

        var RoomsCount = 0;
        var AdultCount = 0;
        var ChildCount = 0;

        var collection = $(".optionBox");
        var totalArray = new Array();
        collection.each(function (index) {

            var tempChildArr = [];
            RoomsCount = parseInt(RoomsCount) + parseInt(1);
            AdultCount = parseInt(AdultCount) + parseInt($(this).find(".adult :selected").val());
            ChildCount = parseInt(ChildCount) + parseInt($(this).find(".child :selected").val());

            var collectionAge = $(this).find('.agess');
            collectionAge.each(function (index) {
                var tempArr = [];
                var cwb = "no";
                if ($(this).find(".ageCWB").prop('checked') == true) {
                    cwb = "yes";
                }

                tempChildArr.push({
                    cwb: cwb,
                    age: parseInt($(this).find(".age :selected").val())
                });

            });
            totalArray.push({
                room: RoomsCount,
                adult: parseInt($(this).find(".adult :selected").val()),
                child: parseInt($(this).find(".child :selected").val()),
                childAge: tempChildArr
            });
        });

        createCookie('searchGuestArr', JSON.stringify(totalArray), 1);
        createCookie('searchGuestRoomCount', JSON.stringify(RoomsCount), 1);
        createCookie('searchGuestChildCount', JSON.stringify(ChildCount), 1);
        createCookie('searchGuestAdultCount', JSON.stringify(AdultCount), 1);
        $('.js-count-adult').html(AdultCount);
        $('.js-count-child').html(ChildCount);
        $('.js-count-room').html(RoomsCount);

        //$(".guestModal .pointer").trigger('click');
        $(".guestModal").addClass('is-hidden');
    });

    jQuery(document).on('click', '.wishlistMe', function () {
        // $(this).addClass('teampCLS');
        var tempD = $(this);
        if ($(this).attr('data-wishlist-u-id') > 0) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: moduleConfig.addToWishList,
                type: "POST",
                dataType: "json",
                data: {
                    user_id: $(this).attr('data-wishlist-u-id'),
                    hotel_id: $(this).attr('data-wishlist-h-id'),
                    type: $(this).attr('data-wishlist-type'),
                },
                success: function (data) {

                    tempD.removeClass('active');
                    // tempD.removeClass('inactive');
                    tempD.addClass(data.class);


                }
            });
            $(this).removeClass('teampCLS');

        }

        // createCookie('wishListByUserID', JSON.stringify(AdultCount), 1);       
        // createCookie('wishListByUserArr', JSON.stringify(AdultCount), 1);       
    });


    function getSelectedChilds(old_child, new_child) {

        if (new_child > old_child) {
            return new_child - old_child;
        } else if (new_child < old_child) {           
            return old_child - new_child;
        } else {           
            return 0;
        }
    }

    function isAddChild(old_child, new_child) {

        if (new_child > old_child) {
            return true;
        }
        return false;
    }



    jQuery(document).on('change', '.addDynamicChilds', function () {
        //  $(this).closest('.optionBox').find('.dynamicChilds').html('');
        var roomNumber = $(this).closest('.optionBox').find('.roomNumber').html();

        var oldchild = $(this).attr('data-old-c');
        
        $(this).attr('data-old-c', $(this).val());
        var neddtoaddorremove = parseInt(getSelectedChilds( parseInt(oldchild), parseInt($(this).val())));
        
        if (isAddChild(parseInt(oldchild), parseInt($(this).val()))) {
            if (neddtoaddorremove > 0) {                
                j = oldchild;
                for (var i = 1; i <= neddtoaddorremove; i++) {                   
                    var agess = `<div class="col-lg-2 agess">
                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Age
                    <div class="tooltip-trigger-popup">
                                                <div class="tooltip -top ">
                                                    <i class="fa fa-question-circle" aria-hidden="true"></i>                                                   
                                                    <div class="tooltip__content">You want child with bed please check the checkbox</div>
                                                </div>
                                            </div>
                    </label>
                    <select name="age" id="age" class="age ">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select>
                    <div class="d-flex px-5 py-5 ageCWBCHK">
                          <div class="form-checkbox ">
                            <input type="checkbox" name="ageCWB[`+ roomNumber + `][` + j + `]" class="ageCWB" value="yes">
                            <div class="form-checkbox__mark">
                              <div class="form-checkbox__icon icon-check"></div>
                            </div>
                            <div class="text-14 lh-12 ml-10">CWB</div>
                                            
                        </div>                        
                </div>  `;
        j++
                    $(this).closest('.optionBox').find('.dynamicChilds').append(agess);
        
                }
            } 
        } else {
            if (neddtoaddorremove > 0) {
                for (var i = 1; i <= neddtoaddorremove; i++) {
                    $(this).closest('.optionBox').find('.dynamicChilds').children("div.agess").last().remove();

                }
            }
        }
        
    });

    // jQuery(document).on('change', '.age', function () {

    //     if ($(this).val() > 2) {
    //         $(this).closest('.optionBox .agess').find('.ageCWBCHK').removeClass('is-hide');
    //         $(this).closest('.optionBox .agess').find('.ageCWBCHK').addClass('is-show');
    //     } else {
    //         $(this).closest('.optionBox .agess').find('.ageCWBCHK .ageCWB').attr('checked', false);
    //         $(this).closest('.optionBox .agess').find('.ageCWBCHK').removeClass('is-show');
    //         $(this).closest('.optionBox .agess').find('.ageCWBCHK').addClass('is-hide');
    //     }

    // });
}

function changeNumber() {

    var collection = $(".optionBox");
    collection.each(function (index) {
        var t = parseInt(index) + parseInt(1);
        $(this).find('.roomNumber').html(t);
    });
}

function getAllRoomslList(hotel_id) {

    $.ajax({
        type: 'POST',
        url: moduleConfig.ajaxRoomURL,
        dataType: 'json',
        beforeSend: function () {
            $(".slide-out-div-h-" + hotel_id).removeClass('is-hide');
            $("#overlay-" + hotel_id).show();
            //$('.ajax-list-display').hide();
        },
        complete: function () {
            // $('.ajax-list-display').show();
            $("#overlay-" + hotel_id).hide();
            $(".slide-out-div-h-" + hotel_id).addClass('is-hide');
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            filterObjParamHotelID: hotel_id,
            filterObjParamStartDate: moduleConfig.filterObjParamStartDate,
            filterObjParamEndDate: moduleConfig.filterObjParamEndDate,
            filterObjParamCityID: moduleConfig.filterObjParamCityID,
            filterObjParamAdult: moduleConfig.filterObjParamAdult,
            filterObjParamChild: moduleConfig.filterObjParamChild,

            filterObjParamChildAge1: moduleConfig.filterObjParamChildAge1,
            filterObjParamChildAge2: moduleConfig.filterObjParamChildAge2,
            filterObjParamChildYounger: moduleConfig.filterObjParamChildYounger,
            filterObjParamChildOlder: moduleConfig.filterObjParamChildOlder,
            filterObjParamRoom: moduleConfig.filterObjParamRoom,
            filterObjParamStartPrice: moduleConfig.filterObjParamStartPrice,
            filterObjParamEndPrice: moduleConfig.filterObjParamEndPrice,

        },
        success: function (data) {
            if (data.status == 200) {
                //$('.foundPropertyCount').html('');
                // $('.foundPropertyCount').html(data.count);
                //$('.ajax-list-display').html('');
                //$('.ajax-list-display').html(data.data);

                $('.slide-out-div-' + hotel_id).html('');
                $('.slide-out-div-' + hotel_id).html(data.data);
                $('.slide-out-div-' + hotel_id).removeClass('is-hide');

                if ($('.slide-out-div-' + hotel_id).is(":hidden")) {
                    $('.slide-out-div-' + hotel_id).slideDown("slow");
                } else {
                    //$('.slide-out-div-' + hotel_id).slideUp('slow');
                }

            }
        }
    });
}

function liveSearches() {

    const data = MySearchArr['city'];
    const hotelData = MySearchArr['hotel'];


    const targets = document.querySelectorAll('.js-liverSearch')
    if (!targets) return


    targets.forEach(el => {
        const search = el.querySelector('.js-search')
        const results = el.querySelector('.js-results')
        let searchTerm = ''

        results.querySelectorAll('.js-search-option').forEach(option => {

            const title = option.querySelector('.js-search-option-target').innerHTML
            option.addEventListener('click', () => {

                const cityId = $(option).attr('data-city_id');
                const CountryId = $(option).attr('data-country_id');
                const HotelId = $(option).attr('data-hotel_id');
                const countryName = $(option).attr('data-country_name');
                $('.hidden_city_id').val(cityId);
                $('.hidden_country_id').val(CountryId);
                $('.hidden_hotel_id').val(HotelId);

                search.value = title.replace(/^\s+|\s+$/gm, '')



                createCookie('location', JSON.stringify(search.value), 1);
                createCookie('hidden_city_id', JSON.stringify(cityId), 1);
                createCookie('hidden_hotel_id', JSON.stringify(HotelId), 1);
                createCookie('country_id', JSON.stringify(CountryId), 1);
                createCookie('countryName', JSON.stringify(countryName), 1);



                el.querySelector('.js-popup-window').classList.remove('-is-active')
            })
        })

        search.addEventListener('input', (event) => {
            searchTerm = event.target.value.toLowerCase()
            showList(searchTerm, results)

            results.querySelectorAll('.js-search-option').forEach(option => {
                const title = option.querySelector('.js-search-option-target').innerHTML

                option.addEventListener('click', () => {
                    search.value = title.replace(/^\s+|\s+$/gm, '')
                    el.querySelector('.js-popup-window').classList.remove('-is-active')
                })
            })
        })
    })

    const showList = (searchTerm, resultsEl) => {

        resultsEl.innerHTML = '';
        var div5 = "";
        const div1 = document.createElement('div')
        div1.className = "locationDiv";
        div1.innerHTML = `<h4 class="text-18 fw-500">Destinations & zones</h4>`;
        data.filter((item) => item.city.toLowerCase().includes(searchTerm))
            .forEach((e) => {

                const div = document.createElement('div')
                div.innerHTML = `
            <button type="button" class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-city_id="${e.city_id}" data-country_id="${e.country_id}" data-country_name="${e.country}">
              <div class="d-flex">
                <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                <div class="ml-10">
                  <div class="text-15 lh-12 fw-500 js-search-option-target">${e.city}</div>
                  <div class="text-14 lh-12 text-light-1 mt-5">${e.country}</div>
                </div>
              </div>
            </button>
          `
                div1.appendChild(div);

            })
        resultsEl.appendChild(div1);

        if (hotelData.length !== 0) {
            const div2 = document.createElement('div')
            div2.className = "hotelDiv";
            div2.innerHTML = `<h4 class="text-18 fw-500">Hotels</h4>`;

            hotelData.filter((item) => item.hotel_name.toLowerCase().includes(searchTerm))
                .forEach((e) => {
                    const div3 = document.createElement('div')
                    div3.innerHTML = `
            <button type="button" class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-hotel_id="${e.hotel_id}" data-city_id="${e.city_id}" data-country_id="${e.country_id}" data-country_name="${e.country}">
              <div class="d-flex">
                <div class="icon-bed text-light-1 text-20 pt-4"></div>
                <div class="ml-10">
                  <div class="text-15 lh-12 fw-500 js-search-option-target">${e.hotel_name}</div>
                  <div class="text-14 lh-12 text-light-1 mt-5">${e.city}${e.country}</div>
                </div>
              </div>
            </button>
          `
                    div2.appendChild(div3);

                })


            resultsEl.appendChild(div2);
        }
    }
}

function priceRangeSlider() {
    const targets = document.querySelectorAll('.js-price-rangeSlider')

    targets.forEach(el => {
        const slider = el.querySelector('.js-slider')

        noUiSlider.create(slider, {
            start: [0, 500],
            step: 100,
            connect: true,
            range: {
                'min': 0,
                'max': 2000
            },
            format: {
                to: function (value) {
                    return "$" + value
                },

                from: function (value) {
                    return value;
                }
            }
        })

        const snapValues = [
            el.querySelector('.js-lower'),
            el.querySelector('.js-upper')
        ]

        slider.noUiSlider.on('update', function (values, handle) {
            snapValues[handle].innerHTML = values[handle];
        })
    })
}

