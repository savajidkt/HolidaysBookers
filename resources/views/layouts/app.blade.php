<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-x="html" data-x-toggle="html-overflow-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title') | {{ config('app.name', 'Holidays  Bookers') }} </title>
    <link href="{{ asset('assets/front/img/favicon.png') }}" rel="icon">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/app.css') }}">
    <!-- Main-StyleSheet include -->
    <style>
        .help-block-error,
        .invalid-feedback {
            color: #EA5455;
        }

        .overlay,
        #overlay {
            position: relative;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: transparent;
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none !important;
        }

        .is-show {
            display: flex !important;
        }

        .mainSearch.-col-4 .button-grid.transfer-cls {
            grid-template-columns: 1fr 1fr auto auto auto auto;
        }

        .guestModal {
            height: 70vh !important;
            overflow: hidden;
            overflow-y: scroll;
        }

        .dynamicChilds,
        .ddynamicChilds {
            display: flex;
        }

        .floatright {
            float: right;
        }

        .loginModal .langMenu__content {

            width: 30% !important;
            max-width: 30% !important;

        }

        .loginModal .button {

            width: 100% !important;


        }
    </style>
</head>



<body>


    <div class="preloader js-preloader">
        <div class="preloader__wrap">
            <div class="preloader__icon">
                <svg width="38" height="37" viewBox="0 0 38 37" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_1_41)">
                        <path
                            d="M32.9675 13.9422C32.9675 6.25436 26.7129 0 19.0251 0C11.3372 0 5.08289 6.25436 5.08289 13.9422C5.08289 17.1322 7.32025 21.6568 11.7327 27.3906C13.0538 29.1071 14.3656 30.6662 15.4621 31.9166V35.8212C15.4621 36.4279 15.9539 36.92 16.561 36.92H21.4895C22.0965 36.92 22.5883 36.4279 22.5883 35.8212V31.9166C23.6849 30.6662 24.9966 29.1071 26.3177 27.3906C30.7302 21.6568 32.9675 17.1322 32.9675 13.9422V13.9422ZM30.7699 13.9422C30.7699 16.9956 27.9286 21.6204 24.8175 25.7245H23.4375C25.1039 20.7174 25.9484 16.7575 25.9484 13.9422C25.9484 10.3587 25.3079 6.97207 24.1445 4.40684C23.9229 3.91841 23.6857 3.46886 23.4347 3.05761C27.732 4.80457 30.7699 9.02494 30.7699 13.9422ZM20.3906 34.7224H17.6598V32.5991H20.3906V34.7224ZM21.0007 30.4014H17.0587C16.4167 29.6679 15.7024 28.8305 14.9602 27.9224H16.1398C16.1429 27.9224 16.146 27.9227 16.1489 27.9227C16.152 27.9227 23.0902 27.9224 23.0902 27.9224C22.3725 28.8049 21.6658 29.6398 21.0007 30.4014ZM19.0251 2.19765C20.1084 2.19765 21.2447 3.33365 22.1429 5.3144C23.1798 7.60078 23.7508 10.6649 23.7508 13.9422C23.7508 16.6099 22.8415 20.6748 21.1185 25.7245H16.9322C15.2086 20.6743 14.2994 16.6108 14.2994 13.9422C14.2994 10.6649 14.8706 7.60078 15.9075 5.3144C16.8057 3.33365 17.942 2.19765 19.0251 2.19765V2.19765ZM7.28053 13.9422C7.28053 9.02494 10.3184 4.80457 14.6157 3.05761C14.3647 3.46886 14.1273 3.91841 13.9059 4.40684C12.7425 6.97207 12.102 10.3587 12.102 13.9422C12.102 16.7584 12.9462 20.7176 14.6126 25.7245H13.2259C9.33565 20.6126 7.28053 16.5429 7.28053 13.9422Z"
                            fill="#3554D1" />
                    </g>

                    <defs>
                        <clipPath id="clip0_1_41">
                            <rect width="36.92" height="36.92" fill="white" transform="translate(0.540039)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </div>
        <div class="preloader__title">HB</div>
    </div>

    {{-- @if (!(Route::is('login') || Route::is('password.request') || Route::is('password.reset')))
        @include('common.header')
    @endif --}}
    <main>
        @if (Route::has('hotel-details'))
            <div class="header-margin"></div>
        @endif
        @include('common.header')
        @yield('content')
        @include('common.footer')
    </main>

    @include('layouts.front-scripts')
    @yield('page-script')

    @if (Route::has('home'))
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).on('click', '.popupShow', function() {

                $("#login").on("show.bs.modal", function(t) {
                    $("#register").modal("hide");
                });
                $("#login").modal("show");
            });
            $(document).on('click', '.popupRegister', function() {
                $("#register").on("show.bs.modal", function(t) {
                    $("#login").modal("hide");
                });
                $("#register").modal("show");
            });
        </script>
    @endif
</body>

</html>
