<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" /> --}}
    <style>
        @media print {
            @page {
                size: A3;
            }
        }

        ul {
            padding: 0;
            margin: 0 0 1rem 0;
            list-style: none;
        }

        body {
            font-family: "Inter", sans-serif;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        table th,
        table td {
            border: 1px solid silver;
        }

        table th,
        table td {
            text-align: right;
            padding: 8px;
        }

        h1,
        h4,
        p {
            margin: 0;
        }

        .container {
            padding: 20px 0;
            width: 1000px;
            max-width: 90%;
            margin: 0 auto;
        }

        .inv-title {
            padding: 10px;
            border: 1px solid silver;
            text-align: center;
            margin-bottom: 30px;
        }

        .inv-logo {
            width: 150px;
            display: block;
            margin: 0 auto;
            margin-bottom: 40px;
        }

        /* header */
        .inv-header {
            display: flex;
            margin-bottom: 20px;
        }

        .inv-header> :nth-child(1) {
            flex: 2;
        }

        .inv-header> :nth-child(2) {
            flex: 1;
        }

        .inv-header h2 {
            font-size: 20px;
            margin: 0 0 0.3rem 0;
        }

        .inv-header ul li {
            font-size: 15px;
            padding: 3px 0;
        }

        /* body */
        .inv-body table th,
        .inv-body table td {
            text-align: left;
        }

        .inv-body {
            margin-bottom: 30px;
        }

        /* footer */
        .inv-footer {
            display: flex;
            flex-direction: row;
        }

        .inv-footer> :nth-child(1) {
            flex: 2;
        }

        .inv-footer> :nth-child(2) {
            flex: 1;
        }
    </style>
</head>







<body>
    <div class="container">
        <div class="inv-title">
            <h1>Recibo # {{ $invoice->id }}</h1>
        </div>
        <div class="inv-header">
            <img src="images/logo-demo.png" align="top" width="196" height="125" />

            <div>
                <ul>
                    <small>
                        <br>
                        <strong>{{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->landlord->name }}</strong><br>
                        {{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->landlord->address }}<br>
                        {{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->landlord->phone }}<br>
                        {{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->landlord->email }}
                    </small>
                </ul>
                @if ($invoice->category == 'Ingreso')
                    <ul>
                        <small>
                            Para:<br>
                            <strong>{{ App\Models\Tenant::whereId($invoice->lease->tenant)->first()->name }}</strong><br>
                            {{ App\Models\Tenant::whereId($invoice->lease->tenant)->first()->address }}<br>
                            {{ App\Models\Tenant::whereId($invoice->lease->tenant)->first()->phone }}<br>
                            Email:
                            {{ App\Models\Tenant::whereId($invoice->lease->tenant)->first()->email }}</a>
                        </small>

                    </ul>
                @endif

            </div>

            <div>
                <table>
                    <tr>
                        <th>Fecha de Emisión</th>
                        <td> {{ $invoice->start_date }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Vencimiento</th>
                        <td> {{ $invoice->start_date }}</td>
                    </tr>
                    <tr>
                        <th>Sub total</th>
                        <td> {{ Number::currency($invoice->ammount) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Total (IVA 16%)</th>
                        <td> {{ Number::currency($invoice->ammount * 1.16) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="inv-body">
            <table>
                <thead>
                    <th>Propiedad</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h4> {{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->title }}
                            </h4>
                            <p> {{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->location }}
                            </p>
                        </td>
                        <td>
                            {{ $invoice->concept }} <small>({{ $invoice->comment }})</small>


                        </td>
                        <td> {{ Number::currency($invoice->ammount) }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="inv-footer">

            <div>
                <table>
                    <tr>
                        <th>Sub total</th>
                        <td> {{ Number::currency($invoice->ammount) }}</td>
                    </tr>
                    <tr>
                        <th>IVA (16%)</th>
                        <td> {{ Number::currency($invoice->ammount * 0.16) }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td> {{ Number::currency($invoice->ammount * 1.16) }}</td>
                    </tr>
                </table>
            </div>
        </div>


    </div>
</body>

</html>
