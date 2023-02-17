@extends('admin.layout.app')
@section('page_title','Admin Dashboard')
@section('content')
<!-- Dashboard Ecommerce Starts -->
<div>Welcome to {{auth()->user()->name}}</div>
<!-- Dashboard Ecommerce ends -->
<form action="" method="get">
  <div class="row mt-2">

    <div class="col-lg-2 col-md-2 col-12">
      <label>Company</label>
      <select name="company" class="form-control" id="company">
        <option value="">Select</option>
        
      </select>
    </div>
    <div class="col-lg-2 col-md-2 col-12">
      <label>Project</label>
      <select name="project" class="form-control" id="project">
        <option value="">Select</option>
        
      </select>
    </div>
    <div class="col-lg-2 col-md-3 col-12">
      <label>From Date</label>
      <input type="text" id="from_date" class="form-control flatpickr-disabled-range" placeholder="MM-DD-YYYY" />
    </div>
    <div class="col-lg-2 col-md-3 col-12">
      <label>To Date</label>
      <input type="text" id="to_date" class="form-control flatpickr-disabled-range" placeholder="MM-DD-YYYY" />
    </div>
    <div class="col-lg-2 col-md-3 col-12">
      <label>&nbsp;</label>
      <button type="button" class="mt-2 btn btn-primary mr-1 waves-effect waves-float waves-light filter">Filter</button>
    </div>

  </div>
</form>
<div class="row mt-2">
  <div class="col-lg-6 col-md-6 col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Results</h4>
      </div>
      <div class="card-body p-0">
        <div id="result-chart">
          
        </div>
      </div>
    </div>
  </div>

  <!-- Timeline Card -->
  <div class="col-lg-6 col-12">
    <div class="card card-user-timeline timeline-cus-height">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <i data-feather="list" class="user-timeline-title-icon"></i>
          <h4 class="card-title">Recent Activity</h4>
        </div>
      </div>
      <div class="card-body" id="recent-activity">
        
      </div>
    </div>
  </div>

</div>

@endsection

@section('extra-script')
<script>
  var disabledRangePickr = $('.flatpickr-disabled-range');
  disabledRangePickr.flatpickr({
      dateFormat: 'm-d-Y',
      disable: [
        {
          from: new Date().fp_incr(2),
          to: new Date().fp_incr(7)
        }
      ]
    });
 
 

  $(document).ready(function() {
    $(".filter").click(function() {
      var company = $('#company').val();
      var project = $('#project').val();
      var fromDate = $('#from_date').val();
      var toDate = $('#to_date').val();
      var data = {
          company: company,
          project: project,
          fromDate: fromDate,
          toDate: toDate
        };
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: 'POST',
        url: "{{route('get-dashboard')}}",
        dataType: 'json',
        data: data,
        success: function(data) {
          if (data.status) {

            goalOverviewChart.destroy();
            chartView(data.survey_results.percentage);
            $('#completed').text(data.survey_results.completed);
            $('#pending').text(data.survey_results.pending);
            $('#recent-activity').html(data.dataActivity);
            
          }
        }
      });
    });


  });
</script>
@endsection('extra-script')