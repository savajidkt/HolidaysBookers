var FrmProductMarkupPreference = function () {
    var ProductMarkupFormValidation = function () {
        var FrmProductMarkupPreferenceForm = $('#FrmProductMarkup');
        var error4 = $('.error-message', FrmProductMarkupPreferenceForm);
        var success4 = $('.error-message', FrmProductMarkupPreferenceForm);

        FrmProductMarkupPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                name: { required: true },
                percentage: { required: true },
                status: { required: true }
            },
            messages: {
                name: {
                    required: $("input[name=name]").attr('data-error')
                },
                percentage: {
                    required: $("input[name=percentage]").attr('data-error')
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
            ProductMarkupFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmProductMarkupPreference.init();
});