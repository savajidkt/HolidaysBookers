var FrmAmenityPreference = function() {
    var AmenityFormValidation = function() {
        var FrmAmenityPreferenceForm = $('#FrmAmenity');
        var error4 = $('.error-message', FrmAmenityPreferenceForm);
        var success4 = $('.error-message', FrmAmenityPreferenceForm);

        FrmAmenityPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                amenity_name: { required: true },
                type: { required: true },
                status: { required: true }
            },
            messages: {
                amenity_name: {
                    required: $("input[name=amenity_name]").attr('data-error')
                },
                type: {
                    required: $("select[name=type]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                } else if (element.attr("name") == "type") {
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
            AmenityFormValidation();
        }
    };
}();

$(document).ready(function() {
    FrmAmenityPreference.init();
});