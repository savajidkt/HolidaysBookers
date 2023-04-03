var FrmSearchPreference = function () {
    var FrmSearchFormValidation = function () {
        var FrmSearchPreferenceForm = $('#FrmSearch');
        var error4 = $('.error-message', FrmSearchPreferenceForm);
        var success4 = $('.error-message', FrmSearchPreferenceForm);

        FrmSearchPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: { required: true },
                status: { required: true }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
                },

            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                // $(".buttonLoader").removeClass('hide');
                //  form.submit();
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
    //FrmSearchPreference.init();

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
                        var Citydata ='';
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
                console.log(ui);
                $('#hidden_city').val(ui.item.city_code);               
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


});