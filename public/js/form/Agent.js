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
                agent_country: { required: true },
                agent_state: { required: true },
                agent_city: { required: true },
                agent_pincode: { required: true },
                agent_mobile_number: { required: true, digits:true },
                agent_telephone: { digits:true },
                agent_email: { required: true, email: true },
                mgmt_first_name: { required: true },
                mgmt_last_name: { required: true },
                mgmt_contact_number: { required: true, digits:true },
                mgmt_email: { required: true, email: true },
                account_first_name: { required: true },
                account_last_name: { required: true },
                account_contact_number: { required: true, digits:true },
                account_email: { required: true, email: true },
                reserve_first_name: { required: true },
                reserve_last_name: { required: true },
                reserve_contact_number: { required: true, digits:true },
                reserve_email: { required: true, email: true },
                agent_username: { required: true },
                agent_password: { minlength: 6, required: true },
                agent_confirm_password: { equalTo: "#agent_password" },
                status: { required: true }
            },
            messages: {
                agent_company_name: {
                    required: $("input[name=agent_company_name]").attr('data-error')+' is required'
                },
                agent_company_type: {
                    required: $("input[name=agent_company_type]").attr('data-error')+' is required'
                },
                nature_of_business: {
                    required: $("input[name=nature_of_business]").attr('data-error')+' is required'
                },
                agent_first_name: {
                    required: $("input[name=agent_first_name]").attr('data-error')+' is required'
                },
                agent_last_name: {
                    required: $("input[name=agent_last_name]").attr('data-error')+' is required'
                },
                agent_designation: {
                    required: $("input[name=agent_designation]").attr('data-error')+' is required'
                },
                agent_dob: {
                    required: $("input[name=agent_dob]").attr('data-error')+' is required'
                },
                agent_office_address: {
                    required: $("input[name=agent_office_address]").attr('data-error')+' is required'
                },
                agent_country: {
                    required: $("input[name=agent_country]").attr('data-error')+' is required'
                },
                agent_state: {
                    required: $("input[name=agent_state]").attr('data-error')+' is required'
                },
                agent_city: {
                    required: $("input[name=agent_city]").attr('data-error')+' is required'
                },
                agent_pincode: {
                    required: $("input[name=agent_pincode]").attr('data-error')+' is required'
                },
                agent_mobile_number: {
                    required: $("input[name=agent_mobile_number]").attr('data-error')+' is required'
                },
                agent_email: {
                    required: $("input[name=agent_email]").attr('data-error')+' is required'
                },
                mgmt_first_name: {
                    required: $("input[name=mgmt_first_name]").attr('data-error')+' is required'
                },
                mgmt_last_name: {
                    required: $("input[name=mgmt_last_name]").attr('data-error')+' is required'
                },
                mgmt_contact_number: {
                    required: $("input[name=mgmt_contact_number]").attr('data-error')+' is required'
                },
                mgmt_email: {
                    required: $("input[name=mgmt_email]").attr('data-error')+' is required'
                },
                account_first_name: {
                    required: $("input[name=account_first_name]").attr('data-error')+' is required'
                },
                account_last_name: {
                    required: $("input[name=account_last_name]").attr('data-error')+' is required'
                },
                account_contact_number: {
                    required: $("input[name=account_contact_number]").attr('data-error')+' is required'
                },
                account_email: {
                    required: $("input[name=account_email]").attr('data-error')+' is required'
                },
                reserve_first_name: {
                    required: $("input[name=reserve_first_name]").attr('data-error')+' is required'
                },
                reserve_last_name: {
                    required: $("input[name=reserve_last_name]").attr('data-error')+' is required'
                },
                reserve_contact_number: {
                    required: $("input[name=reserve_contact_number]").attr('data-error')+' is required'
                },
                reserve_email: {
                    required: $("input[name=reserve_email]").attr('data-error')+' is required'
                },
                agent_username: {
                    required: $("input[name=agent_username]").attr('data-error')+' is required'
                },
                agent_password: {
                    required: $("input[name=agent_password]").attr('data-error')+' is required'
                },
                agent_confirm_password: {
                    required: $("input[name=agent_confirm_password]").attr('data-error')+' is required'
                },

                status: {
                    required: $("select[name=status]").attr('data-error')+' is required'
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