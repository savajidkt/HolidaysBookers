var FrmAgentPreference = function () {
    var AgentFormValidation = function () {
        var FrmAgentPreferenceForm = $('#FrmAgent');
        var error4 = $('.error-message', FrmAgentPreferenceForm);
        var success4 = $('.error-message', FrmAgentPreferenceForm);

        FrmAgentPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                agent_company_name: { required: true },
                agent_company_type: { required: true },
                nature_of_business: { required: true },
                agent_first_name: { required: true },
                agent_last_name: { required: true },
                agent_designation: { required: true },
                agent_dob: { required: true },
                agent_office_address: { required: true },
                agent_pincode: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                agent_company_type: { required: true },
                status: { required: true }
            },
            messages: {
                agent_company_name: {
                    required: $("input[name=agent_company_name]").attr('data-error')
                },
                agent_company_type: {
                    required: $("input[name=agent_company_type]").attr('data-error')
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
            AgentFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmAgentPreference.init();
});