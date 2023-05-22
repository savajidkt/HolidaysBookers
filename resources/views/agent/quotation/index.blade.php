@extends('agent.layouts.app')
@section('page_title', 'Quotation')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Quotation History</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
                <a href="{{ route('home') }}" class="button h-50 px-24 -dark-1 bg-blue-1 text-white">
                    <i class="fa fa-plus-circle mr-2 pr-10"></i> New Quotation
                </a>
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
            <div class="tabs -underline-2 js-tabs">
                <table class="table-3 -border-bottom col-12">
                    <thead class="bg-light-2">
                        <tr>
                            <th>Quote Id</th>
                            <th>Booking Date</th>
                            <th>Type</th>
                            <th>Guest Lead</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Pax</th>
                            <th>Amount</th>                                                      
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="booking-history-type d-flex items-center">                                
                                <small class="ml-2 text-capitalize">1</small>
                            </td>
                            <td>
                                2023-05-01
                            </td>
                            <td>
                                Hotel
                            </td>
                            <td>
                                Jayesh Patel
                            </td>
                            <td>Jayesh Patel</td>
                            <td>abc@gmail.com</td>
                            <td>4</td>
                            <td>4000.00</td>
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
                                                    href="https://gotrip.bookingcore.org/vendor/enquiry-report/1/reply"><i
                                                        class="fa fa-paper-plane"></i> Send</a>
                                            </div>
                                            <div>
                                                <a class="d-block"
                                                    href="https://gotrip.bookingcore.org/vendor/enquiry-report/bulkEdit/1?status=pending&amp;signature=13343260b1cd6cfedab14933ffc4e3e499fe618f28ea1ae2d55381b725bcfc8b">
                                                    <i class="fa fa-pencil-square-o"></i> Edit
                                                </a>
                                            </div>
                                            <div>
                                                <a class="d-block"
                                                    href="https://gotrip.bookingcore.org/vendor/enquiry-report/bulkEdit/1?status=completed&amp;signature=187fc79a10dd15d08d8323c027328edda3c3f68feb4dc6e4ea36c15212b93eef">
                                                    <i class="fa fa-download"></i> Download
                                                </a>
                                            </div>
                                            <div>
                                                <a class="d-block"
                                                    href="https://gotrip.bookingcore.org/vendor/enquiry-report/bulkEdit/1?status=cancel&amp;signature=7857fb2f9f0545a1ede47fb081cc54aabc879aa18c2541cf91436d29fd19e971">
                                                    <i class="fa fa-shopping-cart"></i> Booking
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
                            No Transaction History
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
