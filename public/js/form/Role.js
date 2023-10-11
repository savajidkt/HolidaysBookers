var FrmRolesPreference = function() {
    var RolesFormValidation = function() {
        var FrmRolesPreferenceForm = $('#FrmRoles');
        var error4 = $('.error-message', FrmRolesPreferenceForm);
        var success4 = $('.error-message', FrmRolesPreferenceForm);

        FrmRolesPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                rolename: { required: true },
            },
            messages: {
                rolename: {
                    required: $("input[name=rolename]").attr('data-error')
                },
            },
            errorPlacement: function(error, element) {

                error.insertAfter(element);

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
            RolesFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmRolesPreference.init();
});