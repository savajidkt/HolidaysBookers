var FrmHotelStayRequestPreference = function () {
    var stayRequestFormValidation = function () {
        var FrmHotelStayRequestPreferenceForm = $('#FrmHotelStayRequest');
        var error4 = $('.error-message', FrmHotelStayRequestPreferenceForm);
        var success4 = $('.error-message', FrmHotelStayRequestPreferenceForm);

        FrmHotelStayRequestPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                request: { required: true },                
                status: { required: true }
            },
            messages: {
                request: {
                    required: $("input[name=name]").attr('data-error')
                },                
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                }  else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            stayRequestFormValidation();            
        }
    };
}();

$(document).ready(function () {
    FrmHotelStayRequestPreference.init();
});