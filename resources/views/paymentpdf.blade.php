<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Recibo de Pago</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="images/logo-demo.png" style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                <b>Recibo de Pago</b> ID #: {{ $payment->id }} <br />
                                Fecha del pago: {{ $payment->date }}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <small>
                                    De:<br>
                                    <strong>{{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->name }}</strong><br>
                                    {{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->address }}<br>
                                    {{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->phone }}<br>
                                    {{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->email }}
                                </small>
                            </td>


                        </tr>
                        <tr>
                            <td>
                                <small>
                                    Para:<br>
                                    <strong>{{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->name }}</strong><br>
                                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->address }}<br>
                                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->phone }}<br>
                                    Email:
                                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->email }}</a>
                                </small>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Tipo de Pago</td>

                <td>Propiedad</td>
            </tr>

            <tr class="details">
                <td>{{ $payment->type }}</td>

                <td>{{ App\Models\Property::whereId($payment->lease->property)->first()->title }}</td>
            </tr>

            <tr class="heading">
                <td>Concepto</td>

                <td>Monto</td>
            </tr>

            <tr class="item">
                <td>{{ $payment->concept }}</td>

                <td>{{ Number::currency($payment->ammount) }}</td>
            </tr>

            <tr class="item">
                <td>IVA (16%)</td>

                <td>{{ Number::currency($payment->ammount * 0.16) }}</td>
            </tr>


            <tr class="total">
                <td></td>

                <td>Total: {{ Number::currency($payment->ammount * 1.16) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
