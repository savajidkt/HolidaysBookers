
$(document).ready(function () {

    $(document).on('click', '.removeCart', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            beforeSend: function () {
                $('body').block({ message: null });
            },
            complete: function () {
                $('body').unblock();
            },
            type: 'GET',
            url: moduleConfig.removeCart,
            dataType: 'json',            
            success: function (data) {
                window.location.reload();
            }
        });
    });

    $(document).on('click', '.saveQuote', function () {
        alert('Save Quote');
        return false;
    });
    $(document).on('click', '.removeHotel', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            beforeSend: function () {
                $('body').block({ message: null });
            },
            complete: function () {
                $('body').unblock();
            },
            type: 'POST',
            url: moduleConfig.removeHotel,
            dataType: 'json',
            data: {
                hotel_id: $(this).attr('data-hotel-id'),
                hotel_room_id: $(this).attr('data-hotel-room-id')
            },
            success: function (data) {
                window.location.reload();
            }
        });
    });
});