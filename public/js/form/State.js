var FrmStatePreference = function () {
    var StateFormValidation = function () {
        var FrmStatePreferenceForm = $('#State');
        var error4 = $('.error-message', FrmStatePreferenceForm);
        var success4 = $('.error-message', FrmStatePreferenceForm);
        FrmStatePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                country_id: { required: true },
                name: { required: true },
                code: { required: true },
                status: { required: true }
            },
            messages: {
                country_id: {
                    required: $("select[name=country_id]").attr('data-error')
                },
                name: {
                    required: $("input[name=name]").attr('data-error')
                },
                code: {
                    required: $("input[name=code]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                } else if (element.attr("name") == "country_id") {
                    error.insertAfter("#country");
                } else {
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
            StateFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmStatePreference.init();
});