@extends('agent.layouts.app')
@section('page_title', $pagename)
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Draft History</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
            <div class="tabs -underline-2 js-tabs">                
                <table class="table-3 -border-bottom col-12 user-list-table datatables-ajax table" style="width: 100%;">
                    <thead class="bg-light-2">
                        <tr>
                            <th>S No</th>  
                            <th></th>                         
                            <th>Booking Date</th>                            
                            <th>Guest Lead</th>
                            <th>Pax</th>
                            <th>Amount</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('agent.common.footer')
    </div>
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
    
        $(function() {
            var table = $('.user-list-table').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                ajax: "{{ route('agent.draft') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        visible: false,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },                   
                    {
                        data: 'passenger_type',
                        name: 'passenger_type'
                    },
                    {
                        data: 'pax',
                        name: 'pax'
                    },
                    {
                        data: 'booking_amount',
                        name: 'booking_amount'
                    },
                                        {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                "createdRow": function(row, data, dataIndex) {               
                    $( row ).find('td:eq(4)').addClass('lh-16');
                }
            });           
        });
    </script>
@endsection
