 <!-- BEGIN: Vendor JS-->
 <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @if(Route::is('dashboard'))
    <!-- <script src="{{asset('app-assets/vendors/js/charts/apexcharts.min.js')}}"></script> -->
    @endif
    <script src="{{asset('app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <!-- END: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>    
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->
    <script src="{{asset('app-assets/js/scripts/components/components-bs-toast.js')}}"></script>
    <!-- BEGIN: Page JS-->
    {{-- Sweet Alert --}}
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>

    @if(Route::is('dashboard'))
    <script src="{{asset('app-assets/vendors/js/calendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/moment.min.js')}}"></script>
    <!-- <script src="{{asset('app-assets/js/scripts/pages/dashboard-ecommerce.js')}}"></script> -->
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/pickers/form-pickers.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/pages/app-calendar-events.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/pages/app-calendar.js')}}"></script>
    @endif
    <!-- END: Page JS-->
    <script src="{{asset('js/common.js')}}"></script>


    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
        var url = "{{ route('LangChange') }}";
        $(".dropdown-language .dropdown-item").click(function(){
            window.location.href = url + "?lang="+ $(this).data('language');
        });
    </script>