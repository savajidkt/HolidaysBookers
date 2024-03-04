
@include('emails.partials.template-header')

@php
    $agentData = getAgentDetailsByCode($order->agent_code);     
@endphp
<table>
    <tr>       
        <td class="left-column" style="width: 100%; padding: 25px;" >
            <li style="list-style: none;"><b>Account </b>placed a new order on your store</li>            
        </td>                                      
    </tr>
</table> 

<table cellpadding="0" cellspacing="0" width="100%">
    <tr style="width: 100%; padding: 25px;">
        <td style="padding:25px; text-align: left; width: 60%;">
            <b>To,</b><br>
                {{ $agentData->agent_first_name .' '.$agentData->agent_last_name }}<br>
                (Agent Code) {{ $agentData->agent_code }} <br>
                Email: {{ $agentData->user->email }}<br>
                Mo: {{ $agentData->user->usermeta->phone_number }} <br>           
        </td>
        <td style="padding: 25px; text-align: right; width: 20%;">
            <table style="width: 100%;">
                <tr>
                    <td>Invoice Number</td>
                </tr>
                <tr>
                    <td>Invoice Date</td>
                </tr>
                <tr>
                    <td>PNR No</td>
                </tr>
            </table>
        </td>
        <td style="padding: 25px; text-align: left; width: 20%;">
            <table style="width: 100%;">
                <tr>
                    <td><b>{{ $order->invoice_no }}</b></td>
                </tr>
                <tr>
                    <td><b>{{ dateFormat($order->created_at,'M d, Y') }}</b></td>
                </tr>
                <tr>
                    <td><b>{{ $order->prn_number }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php echo $tableView ?>
@include('emails.partials.template-footer')
