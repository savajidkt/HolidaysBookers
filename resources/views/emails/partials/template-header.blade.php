<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: 'Montserrat', sans-serif;
        }

        .container-table {
            width: 100%;
            padding: 2%;
            box-shadow: 0 0 5px #33333363;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            border-radius: 5px;
        }

        .social-icons a {
            margin-right: 10px;
            color: #fff;
            width: 35px;
            height: 35px;
            background-color: #EE1C25;
            padding: 5px;
            border-radius: 50px;
            text-align: center;
            display: inline-table;
            line-height: 35px;
        }

        .top-content {
            width: 100%;
        }

        .left-column,
        .right-column {
            width: 100%;
            box-sizing: border-box;
        }

        .left-column img {
            width: 100%;
            height: auto;
        }

        .contact-info {
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }



        @media (min-width: 600px) {
            .container-table {
                width: 80%;
            }
        }
    </style>
</head>
@php
    $agentData = getAgentDetailsByCode($order->agent_code);
@endphp

<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <table cellpadding="0" cellspacing="0" border="0" align="center" class="container-table" class="container-table"
        style="width: 1024px;padding: 2%;box-shadow: 0 0 5px #33333363;">
        <tr>
            <td valign="top" class="top-content">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" style="width: 1024px">
                                <table>
                                    <?php 
                                    if( $receive == "admin" ){

                                        ?>

                                    <tr style="background-color: #eaeaea;">
                                        <!-- Left Column -->
                                        <td class="left-column" style="width: 50%; padding: 25px;">
                                            <a href="{{ route('home') }}">
                                                <img style="width:100px;"
                                                    src="{{ url('storage/app/upload/' . $agentData->user_id . '/' . $agentData->agent_company_logo) }}"
                                                    alt="{{ $agentData->agent_company_name }}">
                                            </a>
                                        </td>
                                        <!-- right Column-->
                                        <td class="left-column" style="width: 50%; text-align: end; padding: 25px;">
                                            <h2 style="font-size: 17px; font-weight: 700; color: #091136;">
                                                {{ $agentData->agent_company_name }}<br>
                                                {{ $agentData->agent_office_address }}<br>
                                                City: {{ $agentData->city->name }}, State: {{ $agentData->state->name }}, Country: {{ $agentData->country->name }} - {{ $agentData->agent_pincode }}<br>
                                                (P): {{ $agentData->agent_mobile_number }} <br>
                                                (PAN): {{ $agentData->agent_pan_number }} (GST) {{ $agentData->agent_gst_number }}<br>
                                            </h2>
                                        </td>
                                    </tr>

                                    <?php

                                    } else if( $receive == "agent" ){

                                        ?>

                                    <tr style="background-color: #eaeaea;">
                                        <!-- Left Column -->
                                        <td class="left-column" style="width: 50%; padding: 25px;">
                                            <a href="{{ route('home') }}">
                                                <img src="https://hbsingapore.co.in/public/assets/front/img/general/logo-dark.png"
                                                    alt="logo">
                                            </a>
                                        </td>
                                        <!-- right Column-->
                                        <td class="left-column" style="width: 50%; text-align: end; padding: 25px;">
                                            <h2 style="font-size: 17px; font-weight: 700; color: #091136;">

                                                39A Ground Floor, Sarvodya School,<br>
                                                Aya Nagar, New Delhi 110047<br>
                                                State: Delhi (State Code: 07), Country: India.</h2>
                                        </td>
                                    </tr>

                                    <?php

                                    } 
                                    ?>

                                </table>
