@extends('agent.layouts.app')
@section('page_title', 'Transaction History')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Transaction History</h1>
                
            </div>
            <div class="col-auto">                
                <h1 class="text-30 lh-14 fw-600">Balance: {{ getNumberWithCommaGlobalCurrency(availableBalance($user->agents->id)) }}</h1>
            </div>
        </div>
        <div class="py-30 px-30 rounded-4 bg-white shadow-3 booking-history-manager">
            <div class="tabs -underline-2 js-tabs">
                <div class="tabs__controls row x-gap-40 y-gap-10 lg:x-gap-20 js-tabs-controls">
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','all') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0  {{ $status == 'all' ? 'is-tab-el-active' : '' }} ">
                            All Transaction
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','completed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'completed' ? 'is-tab-el-active' : '' }}">
                            Completed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','processing') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'processing' ? 'is-tab-el-active' : '' }}">
                            Processing
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','confirmed') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'confirmed' ? 'is-tab-el-active' : '' }}">
                            Confirmed
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','cancelled') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'cancelled' ? 'is-tab-el-active' : '' }}">
                            Cancelled
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','paid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'paid' ? 'is-tab-el-active' : '' }}">
                            Paid
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('agent.transaction','unpaid') }}"
                            class="tabs__button text-18 lg:text-16 text-light-1 fw-500 pb-5 lg:pb-0 {{ $status == 'unpaid' ? 'is-tab-el-active' : '' }}">
                            Unpaid
                        </a>
                    </div>                    
                </div>
                <table class="table-3 -border-bottom col-12 user-list-table datatables-ajax table" style="width: 100%;">
                    <thead class="bg-light-2">
                        <tr>
                            <th>S No</th>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
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
@endsection
