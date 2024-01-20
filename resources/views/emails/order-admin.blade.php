
@include('emails.partials.template-header')
<tr>
    <td>
        <table style="width: 100%">
            <tr>
                <td style="padding:40px;">
                    <p style="color:#384860; font-weight:normal; padding-bottom:15px;font-weight:bold;">
                        Welcome to the Holidays Bookers!
                    </p>
                    <p style="padding-bottom:0px;background:#f1f1f1;height:1px;width:100%;margin-bottom:30px;">&nbsp;</p>

                    <p style="color:#384860; font-weight:normal; padding-bottom:5px;">
                        <strong>Order ID: </strong>{{ $order->id }}
                    </p>
					<p style="color:#384860; font-weight:normal; padding-bottom:5px;">
                        <strong>PRN Number: </strong>{{ $order->prn_number }}
                    </p>
					<p style="color:#384860; font-weight:normal; padding-bottom:5px;">
                        <strong>Invoice Number: </strong>{{ $order->invoice_no }}
                    </p>
					<p style="color:#384860; font-weight:normal; padding-bottom:5px;">
                        <strong>Payment Type: </strong>{{ $order->is_pay_using == 1 ? 'Online' : 'Wallet' }}
                    </p>
                    <p style="color:#384860; font-weight:normal; padding-bottom:5px;">
                        <strong>Agent Code: </strong>{{ $order->agent_code }}
                    </p>
                    <p style="color:#384860; font-weight:normal; padding-bottom:5px;">
                        <strong>Agent Email: </strong>{{ $order->agent_email }}
                    </p> 
                    <p style="color:#384860; font-weight:normal; padding-bottom:15px;">
                    <?php echo $tableView ?>
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@include('emails.partials.template-footer')
