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
                search_city: {
                    required: true,
                },
                search_country: {
                    required: true,
                },
                // search_from: { 
                //     search_location_city: true, 
                // },
            },
            messages: {
                // search_from: {
                //     required: 'Check in - Check out is required!'
                // }
            },
            errorPlacement: function (error, element) {

                if (element.attr("name") == "search_from") {
                    console.log(element.attr("name"));
                    error.insertAfter(".dateCLS");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
              
                var form_data = new FormData(form);
                form_data.append("adult", $('.totalAdult').html());
                form_data.append("child", $('.totalChild').html());
                form_data.append("room", $('.totalRoom').html());
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            FrmSearchFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmSearchPreference.init();

    $(function () {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            minDate: new Date()
        }, function (start, end, label) {
            $('#hidden_from').val(start.format('YYYY-MM-DD'));
            $('#hidden_to').val(end.format('YYYY-MM-DD'));
            //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });

    $(function () {
        var cache = {};

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
                        var Citydata = '';
                        $('.locationSearchList .js-results').text();
                        response($.map(data.data, function (item) {
                            Citydata = `<div><button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option" data-city_id="${item.id}" data-country_id="${item.country_id}">
                            <div class="d-flex">
                              <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                              <div class="ml-10">
                                <div class="text-15 lh-12 fw-500 js-search-option-target">${item.name}</div>
                                <div class="text-14 lh-12 text-light-1 mt-5">${item.country}</div>
                              </div>
                            </div>
                          </button></div>`;
                            $('.locationSearchList .js-results').append(Citydata);
                            //Citydata.push({ city: item.name, country: "Greater London, United Kingdom" });                           
                        }));
                        
                        locationSearch();
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                // console.log(ui);
                //$('#hidden_city').val(ui.item.city_code);
            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }

        });

        function locationSearch() {

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
                        $('#hidden_city').val(cityId);
                        $('#hidden_country').val(CountryId);
                        search.value = title
                        el.querySelector('.js-popup-window').classList.remove('-is-active')
                        $('.js-calendar .text-15').trigger('click');
                    })
                })

                search.addEventListener('input', (event) => {

                    searchTerm = event.target.value.toLowerCase()
                    console.log(searchTerm);
                    //showList(searchTerm, results)

                    results.querySelectorAll('.js-search-option').forEach(option => {
                        const title = option.querySelector('.js-search-option-target').innerHTML

                        option.addEventListener('click', () => {
                            search.value = title
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
                    <button class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">
                      <div class="d-flex">
                        <div class="icon-location-2 text-light-1 text-20 pt-4"></div>
                        <div class="ml-10">
                          <div class="text-15 lh-12 fw-500 js-search-option-target">${e.city}</div>
                          <div class="text-14 lh-12 text-light-1 mt-5">${e.country}</div>
                        </div>
                      </div>
                    </button>`
                        resultsEl.appendChild(div)
                    })
            }
        }
    });


    jQuery.validator.addMethod("search_location_city",
        function (value, element) {
            if ($('#search_from').val() == '0' || $('#search_from').val() == 'NuN' || $('#search_from').val() == '' || $('#search_to').val() == '0' || $('#search_to').val() == 'NuN' || $('#search_to').val() == '') {
                return false;
            }
            return true;
        },
        "Check in - Check out is required!");
});