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
                daterange: {
                    required: true,
                }
            },
            messages: {
                location: {
                    required: 'Location is required!'
                },
                daterange: {
                    required: 'Check in - Check out is required!'
                }
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $("<input />").attr("type", "hidden").attr("name", "adult").attr("value", $('.count-adults').html()).appendTo("#SearchFrm");
                $("<input />").attr("type", "hidden").attr("name", "child").attr("value", $('.count-childs').html()).appendTo("#SearchFrm");
                $("<input />").attr("type", "hidden").attr("name", "room").attr("value", $('.count-rooms').html()).appendTo("#SearchFrm");
                form.submit();
            }
        });
    }
    var FrmAutocomplete = function () {
        $("#location").autocomplete({
            source: function (request, response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: moduleConfig.searchLocationByName,
                    type: "POST",
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function (data) {
                        var CityData = [];
                        response($.map(data.data, function (item) {
                            CityData.push({ 'city_id': item.id, 'city': item.name, 'country': item.country, 'country_id': item.country_id });
                        }));
                        liveSearches(CityData);
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            FrmSearchFormValidation();
            FrmAutocomplete();
        }
    };
}();

$(document).ready(function () {
    FrmSearchPreference.init();
    var daterange_transfer_returns = check_in_startDate;
    $(function () {
        $('input[name="daterange"]').daterangepicker({
            startDate: check_in_startDate,
            endDate: check_in_endDate,
            opens: 'left',
            minDate: new Date()
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

                $('.slide-out-div-' + hotel_id).slideUp('slow');
                $('.images-' + hotel_id).slideUp('slow');
                $('.description-' + hotel_id).slideUp('slow');
            } else {
                $('.map-' + hotel_id).slideUp('slow');
            }
        } else if (type == "images") {
            if ($('.images-' + hotel_id).is(":hidden")) {
                $('.images-' + hotel_id).slideDown('slow');

                $('.slide-out-div-' + hotel_id).slideUp('slow');
                $('.map-' + hotel_id).slideUp('slow');
                $('.description-' + hotel_id).slideUp('slow');

            } else {
                $('.images-' + hotel_id).slideUp('slow');
            }
        } else if (type == "description") {
            if ($('.description-' + hotel_id).is(":hidden")) {
                $('.description-' + hotel_id).slideDown('slow');

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
});

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
            filterObjParamAdult: moduleConfig.filterObjParamAdult,
            filterObjParamChild: moduleConfig.filterObjParamChild,
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

                if ($('.slide-out-div-' + hotel_id).is(":hidden")) {
                    $('.slide-out-div-' + hotel_id).slideDown("slow");
                } else {
                    $('.slide-out-div-' + hotel_id).slideUp('slow');
                }

            }
        }
    });
}

function liveSearches(data) {
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
                $('.hidden_city_id').val(cityId);
                $('.hidden_country_id').val(CountryId);

                search.value = title.replace(/^\s+|\s+$/gm, '')
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

        data
            .filter((item) => item.city.toLowerCase().includes(searchTerm))
            .forEach((e) => {
                const div = document.createElement('div')

                div.innerHTML = `
            <button type="button" class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-city_id="${e.city_id}" data-country_id="${e.country_id}">
              <div class="d-flex">
                <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                <div class="ml-10">
                  <div class="text-15 lh-12 fw-500 js-search-option-target">${e.city}</div>
                  <div class="text-14 lh-12 text-light-1 mt-5">${e.country}</div>
                </div>
              </div>
            </button>
          `
                resultsEl.appendChild(div)
            })
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