var FrmMarkupSettingsPreference = function () {

    var FrmMarkupSettingsFormValidation = function () {

        var FrmMarkupSettingsPreferenceForm = $('#FrmMarkupSettings');

        var error4 = $('.error-message', FrmMarkupSettingsPreferenceForm);

        var success4 = $('.error-message', FrmMarkupSettingsPreferenceForm);



        FrmMarkupSettingsPreferenceForm.validate({

            errorElement: 'span',

            errorClass: 'help-block help-block-error',

            focusInvalid: false,

            ignore: "",

            rules: {

                agent_global_markups_type: { required: true },

                agent_global_markup: { required: true }

            },

            messages: {

            },

            errorPlacement: function (error, element) {

                

                error.insertAfter(element);

                

            },

            submitHandler: function (form) {

                

                form.submit();

            }

        });

    }

    return {

        //main function to initiate the module

        init: function () {

            FrmMarkupSettingsFormValidation();

        }

    };

}();



$(document).ready(function () {

    FrmMarkupSettingsPreference.init();

});