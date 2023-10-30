@extends('admin.layout.app')
@section('page_title','Admin Dashboard')
@section('content')
    <style>
        #calendar .fc-daygrid-day-events a {
            color: #fff;
        }
    </style>
<!-- Dashboard Ecommerce Starts -->
    <div>
        <h1>Travel Calendar</h1>
    </div>
<!-- Dashboard Ecommerce ends -->
<div class="app-calendar overflow-hidden border">
  <div class="row no-gutters">
    
    <!-- Calendar -->
    <div class="col position-relative">
      <div class="card shadow-none border-0 mb-0 rounded-0">
        <div class="card-body pb-0">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
    <!-- /Calendar -->
    <div class="body-content-overlay"></div>
  </div>
</div>
@endsection
@section('extra-script')
    <script type="text/javascript">
        var moduleConfig = {
            getAdminBookingList: "{!! route('get-booking-calendar-list') !!}"
        };
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: moduleConfig.getAdminBookingList,
                type: "POST",
                dataType: "json",
                data: {},
                success: function(data) {

                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        events: data.booking,
                        // events: [{
                        //         title: 'All Day Event',
                        //         start: '2023-10-01'
                        //     },
                        //     {
                        //         title: 'Long Event',
                        //         start: '2023-10-07',
                        //         end: '2023-10-10'
                        //     },
                        //     {
                        //         groupId: '999',
                        //         title: 'Repeating Event',
                        //         start: '2023-10-09T16:00:00'
                        //     },
                        //     {
                        //         groupId: '999',
                        //         title: 'Repeating Event',
                        //         start: '2023-10-16T16:00:00'
                        //     },
                        //     {
                        //         title: 'Conference',
                        //         start: '2023-10-11',
                        //         end: '2023-10-15T16:00:00'
                        //     },
                        //     {
                        //         title: 'Meeting',
                        //         start: '2023-10-12T10:30:00',
                        //         end: '2023-10-12T12:30:00'
                        //     },
                        //     {
                        //         title: 'Lunch',
                        //         start: '2023-10-12T12:00:00'
                        //     },
                        //     {
                        //         title: 'Meeting',
                        //         start: '2023-10-12T14:30:00'
                        //     },
                        //     {
                        //         title: 'Birthday Party',
                        //         start: '2023-10-13T07:00:00'
                        //     },
                        //     {
                        //         title: 'Click for Google',
                        //         url: 'http://google.com/',
                        //         start: '2023-10-28'
                        //     },
                        //     {
                        //         title: 'Marrage',
                        //         start: '2023-10-19',
                        //         end: '2023-10-21'
                        //     }
                        // ]

                    });
                    calendar.render();
                }
            });
        });
    </script>
@endsection