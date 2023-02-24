var FrmApiPreference = function () {
    var ApiFormValidation = function () {
        var FrmApiPreferenceForm = $('#apis');
        var error4 = $('.error-message', FrmApiPreferenceForm);
        var success4 = $('.error-message', FrmApiPreferenceForm);

        FrmApiPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: { required: true },
                api_url: { required: true },
                status: { required: true }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
                },
                api_url: {
                    required: $("input[name=api_url]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
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
            ApiFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmApiPreference.init();
});