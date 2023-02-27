var FrmReachPreference = function () {
    var FrmReachFormValidation = function () {
        var FrmReachPreferenceForm = $('#FrmReach');
        var error4 = $('.error-message', FrmReachPreferenceForm);
        var success4 = $('.error-message', FrmReachPreferenceForm);

        FrmReachPreferenceForm.validate({
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
            FrmReachFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmReachPreference.init();
});