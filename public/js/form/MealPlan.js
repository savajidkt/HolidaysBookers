var FrmMealPlansPreference = function() {
    var FrmMealPlansFormValidation = function() {
        var FrmMealPlansPreferenceForm = $('#FrmMealPlans');
        var error4 = $('.error-message', FrmMealPlansPreferenceForm);
        var success4 = $('.error-message', FrmMealPlansPreferenceForm);

        FrmMealPlansPreferenceForm.validate({
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
            FrmMealPlansFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmMealPlansPreference.init();
});