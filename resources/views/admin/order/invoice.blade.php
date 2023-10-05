<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Invoice Print | Holidays Bookers </title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice-print.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->
    <style>
        @media print {
            .btn {
                display: none;
            }
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row demo-inline-spacing">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-secondary waves-effect" href="{{ route('orders.show', $model) }}">
                            Back </a>
                        <a class="btn btn-outline-secondary waves-effect" href="javascript:void(0);"
                            onclick='window.print();'>
                            Print
                        </a>
                        <a class="btn btn-outline-secondary waves-effect" target="_blank"
                            href="{{ route('order-invoice-download', $model) }}"> Download </a>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="invoice-print p-3">
                    <div class="d-flex justify-content-between flex-md-row flex-column pb-2">
                        <div>
                            <div class="d-flex mb-1">
                                <a href="{{ url('/') }}" class="header-logo mr-30" data-x="header-logo"
                                    data-x-toggle="is-logo-dark">
                                    <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="logo icon">
                                </a>
                            </div>

                            <p class="mb-25"><strong>HOLIDAYS BOOKERS DMC INDIA PVT LTD</strong></p>
                            <p class="mb-25">39A Ground Floor, Sarvodya School,</p>
                            <p class="mb-25">Aya Nagar, New Delhi 110047</p>
                            <p class="mb-25">State: Delhi (State Code: 07), Country: India.</p>
                            <p class="mb-25">(P) +91 1148015307/ +91 1142268354 (M) +91 9810560003/+91 991056000</p>
                            <p class="mb-0"> (PAN) <strong>AAECH3953Q</strong> (CIN)
                                <strong>U63030DL2017PTC327553</strong> (GSTIN) <strong>07AAECH3953Q1Z0</strong>
                            </p>
                        </div>
                        <div class="mt-md-0 mt-2">
                            <div class="invoice-date-wrapper mb-50">
                                <span class="font-weight-bold">(w)www.holidaysbookers.com</span>
                            </div>
                            <div class="invoice-date-wrapper">
                                <span class="font-weight-bold">(e)accounts@holidaysbookers.com</span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2" />

                    <div class="row pb-2">
                        <div class="col-sm-6">
                            <h6 class="mb-1">To,</h6>
                            <p class="mb-25">{{ $model->agentcode->user->first_name }}
                                {{ $model->agentcode->user->last_name }}</p>
                            <p class="mb-25">(Agent Code) {{ $model->agent_code }}</p>
                            <p class="mb-25">Email: {{ $model->agentcode->user->email }}</p>
                            <p class="mb-25">Mo: {{ $model->agentcode->user->usermeta->phone_number }}</p>
                            <p class="mb-25 font-weight-bold">Guest Name: {{ $model->guest_lead }}</p>
                            <p class="mb-0 font-weight-bold">Date:
                                {{ date('d M, Y', strtotime($model->check_in_date)) }} To
                                {{ date('d M, Y', strtotime($model->check_out_date)) }}</p>
                        </div>
                        <div class="col-sm-6 mt-sm-0 mt-2">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pr-1">Invoice Number:</td>
                                        <td class="font-weight-bold">{{ $model->invoice_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-1">Invoice Date:</td>
                                        <td class="font-weight-bold">{{ date('d M, Y', strtotime($model->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="pr-1">PNR No.:</td>
                                        <td class="font-weight-bold">{{ $model->prn_number }}</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php echo $orderTable; ?>
                    <hr class="my-2" />
                    <div class="row">
                        <div class="col-12">
                            <span class="font-weight-bold">Terms :</span>
                            <p class="mb-25 font-weight-bold"># Subject to New Delhi jurisdiction.</p>
                            <p class="mb-25 font-weight-bold"># Without original invoice no refund is permissible.</p>
                            <p class="mb-25 font-weight-bold"># Interest @ 24% will be charged on delayed payment. #
                                Cheque to be drawn in favour of "company name".</p>
                            <p class="mb-25 font-weight-bold"># Kindly check all details carefully to avoid
                                un-necessary complications.</p>
                        </div>
                    </div>
                    <hr class="my-2" />
                    <div class="row invoice-sales-total-wrapper mt-3">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold">for HOLIDAYS BOOKERS DMC INDIA PVT LTD</p>
                            <img src="data:image/jpg;base64,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"
                                width="59" height="58">
                        </div>
                        <div class="col-md-6">
                            <p class="font-weight-bold">Receiver's Signature</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="font-weight-bold">Authorized Signatory</p>
                        </div>
                    </div>
                    <hr class="my-2" />
                    <div class="row invoice-sales-total-wrapper mt-3">
                        <div class="col-md-4 text-left">
                            <p class="font-weight-bold">(Prepared by: HOLIDAY BOOKERS)</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <p class="font-weight-bold">This is a Computer generated document and does not require any
                                signature.</p>
                        </div>
                        <div class="col-md-4 text-right">
                            <p class="font-weight-bold">(ID: 803)</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('app-assets/js/scripts/pages/app-invoice-print.js') }}"></script> --}}
    <!-- END: Page JS-->

    <script>
        // $(window).on('load', function() {
        //     if (feather) {
        //         feather.replace({
        //             width: 14,
        //             height: 14
        //         });
        //     }
        // })
    </script>
</body>
<!-- END: Body-->

</html>
