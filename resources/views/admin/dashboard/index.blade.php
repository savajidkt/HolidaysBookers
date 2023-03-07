@extends('admin.layout.app')
@section('page_title','Admin Dashboard')
@section('content')
<!-- Dashboard Ecommerce Starts -->
<div><h1>Travel Calendar</h1></div>
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

@endsection('extra-script')