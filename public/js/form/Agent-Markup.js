var FrmAgentMarkupPreference = function () {
    var AgentMarkupFormValidation = function () {
        var FrmAgentMarkupPreferenceForm = $('#FrmAgentMarkup');
        var error4 = $('.error-message', FrmAgentMarkupPreferenceForm);
        var success4 = $('.error-message', FrmAgentMarkupPreferenceForm);

        FrmAgentMarkupPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                code: { required: true },
                rezlive: { required: true, digits: true },
                offline_hotel: { required: true, digits: true },
                sightseeing: { required: true, digits: true },
                transfer: { required: true, digits: true },
                package: { required: true, digits: true },
                status: { required: true }
            },
            messages: {
                code: {
                    required: $("input[name=code]").attr('data-error')
                },
                rezlive: {
                    required: $("input[name=rezlive]").attr('data-error')
                },
                offline_hotel: {
                    required: $("input[name=offline_hotel]").attr('data-error')
                },
                sightseeing: {
                    required: $("input[name=sightseeing]").attr('data-error')
                },
                transfer: {
                    required: $("input[name=transfer]").attr('data-error')
                },
                package: {
                    required: $("input[name=package]").attr('data-error')
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
            AgentMarkupFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmAgentMarkupPreference.init();
});