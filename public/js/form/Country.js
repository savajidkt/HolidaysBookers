var FrmCountryPreference = function() {
    var CountryFormValidation = function() {
        var FrmCountryPreferenceForm = $('#Country');
        var error4 = $('.error-message', FrmCountryPreferenceForm);
        var success4 = $('.error-message', FrmCountryPreferenceForm);

        FrmCountryPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: { required: true },
                code: { required: true },
                phone_code: { required: true, digits: true, minlength: 1, maxlength: 4 },
                nationality: { required: true },
                status: { required: true }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
                },
                code: {
                    required: $("input[name=code]").attr('data-error')
                },
                phone_code: {
                    required: $("input[name=phone_code]").attr('data-error')
                },
                nationality: {
                    required: $("input[name=nationality]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            CountryFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmCountryPreference.init();
});