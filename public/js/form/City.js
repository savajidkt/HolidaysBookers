var FrmCityPreference = function () {
    var CityFormValidation = function () {
        var FrmCityPreferenceForm = $('#City');
        var error4 = $('.error-message', FrmCityPreferenceForm);
        var success4 = $('.error-message', FrmCityPreferenceForm);

        FrmCityPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                country_id: { required: true },
                state_id: { required: true },
                name: { required: true },
                status: { required: true }
            },
            messages: {
                country_id: {
                    required: $("select[name=country_id]").attr('data-error')
                },
                state_id: {
                    required: $("select[name=state_id]").attr('data-error')
                },
                name: {
                    required: $("input[name=name]").attr('data-error')
                },
                status: {
                    required: $("select[name=status]").attr('data-error')
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "country_id") {
                    error.insertAfter("#country");
                } else if (element.attr("name") == "state_id") {
                    error.insertAfter("#state");
                } else if (element.attr("name") == "status") {
                    error.insertAfter("#status_id");
                } else {
                error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    var getStateList = function () {
        $(document).on('change', '#country_id', function () {
            var country_id = $(this).val();
            $('#state_id').find('option:not(:first)').remove();
            if (country_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    beforeSend: function () {
                        $(".spinner-border").show();
                    },
                    complete: function () {
                        $(".spinner-border").hide();
                    },
                    type: 'POST',
                    url: moduleConfig.redirectUrl,
                    dataType: 'json',
                    data: {
                        country_id: country_id
                    },
                    success: function (data) {
                        if (data.status) {
                            $.each(data.states, function (key, val) {
                                $('#state_id').append(new Option(val.name, val.id));
                            });
                        }
                        $(".spinner-border").hide();
                    }
                });
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            CityFormValidation();
            getStateList();
        }
    };
}();

$(document).ready(function () {
    FrmCityPreference.init();
});