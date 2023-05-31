@extends('agent.layouts.app')
@section('page_title', 'Booking History')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Booking History</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
            <div class="tabs -underline-2 js-tabs">
                <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls pb-30">
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'all') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0  {{ $status == 'all' ? 'is-tab-el-active' : '' }} ">
                            All Booking
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'completed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'completed' ? 'is-tab-el-active' : '' }}">
                            Completed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'processed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'processed' ? 'is-tab-el-active' : '' }}">
                            Processed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'confirmed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'confirmed' ? 'is-tab-el-active' : '' }}">
                            Confirmed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'cancelled ') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'cancelled' ? 'is-tab-el-active' : '' }}">
                            Cancelled
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'paid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'paid' ? 'is-tab-el-active' : '' }}">
                            Paid
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history', 'unpaid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'unpaid' ? 'is-tab-el-active' : '' }}">
                            Unpaid
                        </a>
                    </div>
                </div>
                <table class="table-3 -border-bottom col-12 user-list-table datatables-ajax table">
                    <thead class="bg-light-2">
                        <tr>
                            <th>S No</th>
                            <th></th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Guest Lead</th>
                            <th>Pax</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
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
                processing: true,
                serverSide: true,
                searching: true,
                order: [
                    [1, 'desc']
                ],
                ajax: "{{ route('agent.booking-history', $status) }}",
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
                        data: 'is_pay_using',
                        name: 'is_pay_using'
                    },
                    {
                        data: 'guest_lead',
                        name: 'guest_lead'
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
                        data: 'payment',
                        name: 'payment'
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
