@extends('agent.layouts.app')
@section('page_title', 'Travel Calendar')
@section('content')
    <div class="dashboard__content bg-light-2">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600">Travel Calendar</h1>
                <div class="text-15 text-light-1">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="col-auto">
            </div>
        </div> 
        <div id='calendar'></div>       
        @include('agent.common.footer')
    </div>
@endsection
@section('page-script')
@endsection
