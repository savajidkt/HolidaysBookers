var FrmOfflineRoomPreference = function () {
    var ApiFormValidation = function () {
        var FrmOfflineRoomPreferenceForm = $('#FrmOfflineRoom');
        var error4 = $('.error-message', FrmOfflineRoomPreferenceForm);
        var success4 = $('.error-message', FrmOfflineRoomPreferenceForm);

        FrmOfflineRoomPreferenceForm.validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: "",
            rules: {
                hotel_id: { required: true },               
            },
            messages: {
                hotel_id: {
                    required: 'Hotel is required'
                },
            },
            // errorPlacement: function (error, element) {
            //     if(element.hasClass('select2') && element.next('.select2-container').length) {
            //         error.insertAfter(element.next('.select2-container'));
            //     } else {
            //         error.insertAfter(element);
            //     }
                
            // },
            submitHandler: function (form) {
                $(".buttonLoader").removeClass('hide');
                form.submit();
            }
        });
    }
    return {
        //main function to initiate the module
        init: function () {
            ApiFormValidation();
        }
    };
}();

$(document).ready(function () {
    FrmOfflineRoomPreference.init();

    var selectHotel = $('.select2-hotel');
    // Loading array data
    var data = [
        { id: '', text: '' },
        { id: 0, text: 'TANA DWA  VILLAS & RESORTS BALI' },
        { id: 1, text: 'Kajane Mua' },
        { id: 2, text: 'Diamond Hotel' },
        { id: 3, text: 'Episode Kuta Bali' },
        { id: 4, text: 'Kori Maharani Villa' }
    ];

    selectHotel.wrap('<div class="position-relative"></div>').select2({
        placeholder: "Select Hotel",
        allowClear: true,
        dropdownAutoWidth: true,
        dropdownParent: selectHotel.parent(),
        width: '100%',
        data: data
    });


    var selectRoomType = $('.select2-room-types');
    // Loading array data
    var dataRoom = [
        { id: '', text: '' },
        { id: 1, text: 'Kajane Mua' },
        { id: 2, text: 'Diamond Hotel' },
        { id: 3, text: 'Episode Kuta Bali' },
        { id: 4, text: 'Kori Maharani Villa' }
    ];

    selectRoomType.wrap('<div class="position-relative"></div>').select2({        
        placeholder: "Select",
        allowClear: true,
        dropdownAutoWidth: true,
        dropdownParent: selectRoomType.parent(),
        width: '100%',
        data: dataRoom
    });

    var selectAmenities = $('.select2-room-amenities');
    // Loading array data
    var dataAmenities = [
        { id: '', text: '' },
        { id: 1, text: 'Kajane Mua' },
        { id: 2, text: 'Diamond Hotel' },
        { id: 3, text: 'Episode Kuta Bali' },
        { id: 4, text: 'Kori Maharani Villa' }
    ];

    selectAmenities.wrap('<div class="position-relative"></div>').select2({
        placeholder: "Select",
        allowClear: true,
        dropdownAutoWidth: true,
        dropdownParent: selectAmenities.parent(),
        width: '100%',
        data: dataAmenities
    });
});