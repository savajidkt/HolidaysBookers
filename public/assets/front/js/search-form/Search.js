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
    $(function () {        
        $('input[name="daterange"]').daterangepicker({
            startDate: check_in_startDate,
            endDate: check_in_endDate,
            opens: 'left',
            minDate: new Date()
        }, function (start, end, label) {
            $('#hidden_from').val(start.format('YYYY-MM-DD'));
            $('#hidden_to').val(end.format('YYYY-MM-DD'));
            console.log('u');
        });       
    });
});

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