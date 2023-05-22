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
                        <a href="{{ route('agent.booking-history','all') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0  {{ $status == 'all' ? 'is-tab-el-active' : '' }} ">
                            All Booking
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history','completed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'completed' ? 'is-tab-el-active' : '' }}">
                            Completed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history','processing') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'processing' ? 'is-tab-el-active' : '' }}">
                            Processing
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history','confirmed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'confirmed' ? 'is-tab-el-active' : '' }}">
                            Confirmed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history','cancelled') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'cancelled' ? 'is-tab-el-active' : '' }}">
                            Cancelled
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history','paid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'paid' ? 'is-tab-el-active' : '' }}">
                            Paid
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.booking-history','unpaid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'unpaid' ? 'is-tab-el-active' : '' }}">
                            Unpaid
                        </a>
                    </div>                    
                </div>
                <table class="table-3 -border-bottom col-12">
                    <thead class="bg-light-2">
                        <tr>
                            <th>S NO</th>
                            <th>Booking Date</th>                            
                            <th>Status</th>
                            <th>PNR No</th>
                            <th>Guest Lead</th>                            
                            <th>Pax</th>
                            <th>Service Date</th>
                            <th>Amount(INR)</th>                                                      
                            <th>Payment Status</th>                                                      
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="booking-history-type d-flex items-center">                                
                                1
                            </td>
                            <td>
                                2023-05-01
                            </td>
                            <td>
                                Time Limit
                            </td>
                            <td>
                                1234
                            </td>
                            <td>Jayesh Patel</td>
                            <td>4</td>
                            <td>2022-10-31</td>
                            <td>4000.00</td>
                            <td>Unpaid</td>
                            <td>
                                <div class="dropdown js-dropdown js-actions-1-active">
                                    <div class="dropdown__button d-flex items-center rounded-4 text-blue-1 bg-blue-1-05 text-14 px-15 py-5"
                                        data-el-toggle=".js-actions-1-toggle" data-el-toggle-active=".js-actions-1-active">
                                        <span class="js-dropdown-title">Action</span>
                                        <i class="icon icon-chevron-sm-down text-7 ml-10"></i>
                                    </div>
                                    <div class="toggle-element -dropdown-2 js-click-dropdown js-actions-1-toggle w-200 start-0"
                                        style="max-width:none;left: 0">
                                        <div class="text-14 fw-500 js-dropdown-list">
                                            
                                            <div>
                                                <a class="d-block"
                                                    href="https://gotrip.bookingcore.org/vendor/enquiry-report/bulkEdit/1?status=pending&amp;signature=13343260b1cd6cfedab14933ffc4e3e499fe618f28ea1ae2d55381b725bcfc8b">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </div>
                                            <div>
                                                <a class="d-block"
                                                    href="https://gotrip.bookingcore.org/vendor/enquiry-report/bulkEdit/1?status=completed&amp;signature=187fc79a10dd15d08d8323c027328edda3c3f68feb4dc6e4ea36c15212b93eef">
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="tabs__content pt-30 js-tabs-content">
                    <div class="tabs__pane -tab-item-1 is-tab-el-active">
                        <div class="overflow-scroll scroll-bar-1">
                            No Booking History
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('agent.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
