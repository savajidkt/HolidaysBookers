
$(document).ready(function () {
    Currencies();

    $(document).on('click', '.CurrencyItem', function () {
        
                         
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: moduleConfigCommon.setCurrencies,
            type: "POST",
            dataType: "json",
            data: {
                id: $(this).attr('data-id'),                
            },
            success: function (data) {
                if (data.status) {
                    $('.CurrencyItem').removeClass('-is-active');                    
                    $('.CurrencyItem_'+data.data).addClass('-is-active');  
                    $('.js-currencyMenu-mainTitle').html('');
                    $('.js-currencyMenu-mainTitle').html(data.code);
                    location.reload();
                }
            }
        });
    });

});

function Currencies(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: moduleConfigCommon.allCurrencies,
        type: "GET",
        dataType: "json",
        data: {},
        success: function (data) {
            if (data.status) {
                //var obj = jQuery.parseJSON(response);
                
                $.each(data.data, function (key, value) {
                    var symbol = "";
                    if (value.symbol != null) {
                        symbol = ' - ' + value.symbol;
                    }

                    var isActiveCls = "";
                    if(  data.getdata.id == value.id ){
                        isActiveCls = "-is-active";
                        $('.js-currencyMenu-mainTitle').html('');
                        $('.js-currencyMenu-mainTitle').html(value.code);
                    }
                   
                    var newCurrencyItem = '<div class="CurrencyItem modalGrid__item js-item CurrencyItem_' + value.id + ' '+isActiveCls+'"  data-id="' + value.id + '"  ><div class="py-10 px-15 sm:px-5 sm:py-5"><div class="text-15 lh-15 fw-500 text-dark-1">' + value.name + '</div><div class="text-14 lh-15 mt-5"><span class="js-title">' + value.code + '</span>' + symbol + '</div></div></div>';
                    $(".currencyMenu .modalGrid").append(newCurrencyItem);
                });
            }
        }
    });
}

