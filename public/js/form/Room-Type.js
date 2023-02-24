var FrmRoomTypePreference = function () {
    var RoomTypeFormValidation = function () {
        var FrmRoomTypePreferenceForm = $('#FrmRoomType');
        var error4 = $('.error-message', FrmRoomTypePreferenceForm);
        var success4 = $('.error-message', FrmRoomTypePreferenceForm);

        FrmRoomTypePreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                room_type: { required: true },
                no_of_seats: { required: true },
                status: { required: true }
            },
            messages: {
                room_type: {
                    required: $("input[name=room_type]").attr('data-error')
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
            RoomTypeFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmRoomTypePreference.init();
});