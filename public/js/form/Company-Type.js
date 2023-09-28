var FrmCompanyTypePreference = function() {
    var CompanyTypeFormValidation = function() {
        var FrmCompanyTypePreferenceForm = $('#FrmCompanyType');
        var error4 = $('.error-message', FrmCompanyTypePreferenceForm);
        var success4 = $('.error-message', FrmCompanyTypePreferenceForm);

        FrmCompanyTypePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                company_type: { required: true },
                status: { required: true }
            },
            messages: {
                company_type: {
                    required: $("input[name=company_type]").attr('data-error')
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
            CompanyTypeFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmCompanyTypePreference.init();
});