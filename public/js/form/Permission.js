var FrmPermissionPreference = function() {
    var FrmPermissionFormValidation = function() {
        var FrmPermissionPreferenceForm = $('#FrmPermission');
        var error4 = $('.error-message', FrmPermissionPreferenceForm);
        var success4 = $('.error-message', FrmPermissionPreferenceForm);

        FrmPermissionPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                permission_name: { required: true },
                type: { required: true },
            },
            messages: {
                permission_name: {
                    required: $("input[name=permission_name]").attr('data-error')
                },
                type: {
                    required: $("input[name=type]").attr('data-error')
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "type") {
                    error.insertAfter("#type_id");
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
            FrmPermissionFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmPermissionPreference.init();
});