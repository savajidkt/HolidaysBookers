var FrmCheckoutPreference = function () {
    var FrmCheckoutFormValidation = function () {
        var FrmCheckoutPreferenceForm = $('#CheckoutFrm');
        var error4 = $('.error-message', FrmCheckoutPreferenceForm);
        var success4 = $('.error-message', FrmCheckoutPreferenceForm);

        FrmCheckoutPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                email: {
                    email: true,
                    required: true,
                },
                phone: {
                    required: true,
                },
                registration_number: {
                    required: function () {
                        if ($('input[name="gst_enable"]').is(':checked')) {                        
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                registered_company_name: {
                    required: function () {
                        if ($('input[name="gst_enable"]').is(':checked')) {                        
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                registered_company_address: {
                    required: function () {
                        if ($('input[name="gst_enable"]').is(':checked')) {                        
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                agree: {
                    required: true,
                }
            },
            messages: {
                
            },
            errorPlacement: function (error, element) {              
                if (element.attr("name") == "firstname") {
                    error.insertAfter(".firstname");
                } else if (element.attr("name") == "lastname") {
                    error.insertAfter(".lastname");
                } else if (element.attr("name") == "email") {
                    error.insertAfter(".email");
                } else if (element.attr("name") == "phone") {
                    error.insertAfter(".phone");
                } else if (element.attr("name") == "registration_number") {
                    error.insertAfter(".registration_number");
                } else if (element.attr("name") == "registered_company_name") {
                    error.insertAfter(".registered_company_name");
                } else if (element.attr("name") == "registered_company_address") {
                    error.insertAfter(".registered_company_address");
                } else if (element.attr("name") == "agree") {
                    error.insertAfter(".agree");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {                
                form.submit();
            }
        });
    }
   
    return {
        //main function to initiate the module
        init: function () {
            FrmCheckoutFormValidation();
            
        }
    };
}();

$(document).ready(function () {
    FrmCheckoutPreference.init(); 
    
    $('input[name="gst_enable"]').change(function () {       
        if ( $(this).is(':checked')) {           
            $('.enablegst').removeClass('hide');
        } else {
            $('.enablegst').addClass('hide');
        }
    });
});