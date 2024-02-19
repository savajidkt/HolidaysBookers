
$(document).ready(function () {

    $(document).on('click', '.removeCart', function () {


        swal({
            title: "Are you sure?",
            text: "You won't be remove cart!",
            icon: "warning",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3554d1",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"

        },
            function (resp) {
                if (resp) {
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
                }
            }
        );
    });

    $(document).on('click', '.saveQuote', function () {
        alert('Save Quote');
        return false;
    });
    $(document).on('click', '.removeHotel', function () {


        var hotel_id = $(this).attr('data-hotel-id');
        var hotel_room_id = $(this).attr('data-hotel-room-id');
        var key_id = $(this).attr('data-cart-key');
        swal({
            title: "Are you sure?",
            text: "You won't be remove this!",
            icon: "warning",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3554d1",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"

        },
            function (resp) {
                if (resp) {
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
                            hotel_id: hotel_id,
                            hotel_room_id: hotel_room_id,
                            key_id: key_id
                        },
                        success: function (data) {
                            window.location.reload();
                        }
                    });
                }
            }
        );
    });
});