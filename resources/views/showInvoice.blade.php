@extends('adminlte::page')

@section('title', 'Ver Recibo')

@section('content_header')


@stop

@section('content')







    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Invoice</title>
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
                width: 1200px;
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
                <h4><strong>Recibo de {{ $invoice->category }}</strong></h4>
            </div>
            <div class="inv-header">

                <div>
                    <ul>



                        @if ($invoice->lease_id != 1)
                            {{-- Con este codigo imprimo los recibos CON contrato asociado --}}




                            @if (App\Models\Lease::whereId($invoice->lease_id)->first()->subpropertyname != '--')
                                <h2>Subunidad:
                                    {{ App\Models\Lease::whereId($invoice->lease_id)->first()->subpropertyname }}</h2><br>
                            @else
                                <h2>Unidad:
                                    {{ App\Models\Lease::whereId($invoice->lease_id)->first()->property_->title }}</h2><br>
                            @endif


                            <h2>Propietario:
                                @if ($invoice->lease->subproperty_id != 1)
                                    {{ $invoice->lease->subproperty->landlord->name }}
                                    <ul>
                                        <li><small>
                                                {{ $invoice->lease->subproperty->landlord->address }}</small>
                                        </li>
                                        <li>{{ $invoice->lease->subproperty->landlord->phone }}
                                            |{{ $invoice->lease->subproperty->landlord->email }}
                                        </li>
                                    </ul>
                                @else
                                    {{ $invoice->lease->property_->landlord->name }}
                                    <ul>
                                        <li><small>
                                                {{ $invoice->lease->property_->landlord->address }}</small>
                                        </li>
                                        <li>{{ $invoice->lease->property_->landlord->phone }}
                                            |{{ $invoice->lease->property_->landlord->email }}
                                        </li>
                                    </ul>
                                @endif
                            </h2>
                        @else
                            {{-- Con este codigo imprimo la propiedad asociada para los gastos SIN contrato asociado --}}
                            @if ($invoice->property_id)
                                <h2>Unidad:
                                    {{ App\Models\Property::whereId($invoice->property_id)->first()->title }}</h2><br>
                                <h2>Propietario:
                                    {{ App\Models\Property::whereId($invoice->property_id)->first()->landlord->name }}
                                </h2>
                                <ul>
                                    <li><small>
                                            {{ App\Models\Property::whereId($invoice->property_id)->first()->landlord->address }}</small>
                                    </li>
                                    <li>{{ App\Models\Property::whereId($invoice->property_id)->first()->landlord->phone }}
                                        |{{ App\Models\Property::whereId($invoice->property_id)->first()->landlord->email }}
                                    </li>
                                </ul>
                            @endif
                            @if ($invoice->subproperty_id)
                                <h2>Subunidad:
                                    {{ App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->title }}</h2>
                                <br>
                                <h2>Propietario:
                                    {{ App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->landlord->name }}
                                </h2>
                                <ul>
                                    <li><small>
                                            {{ App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->landlord->address }}</small>
                                    </li>
                                    <li>{{ App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->landlord->phone }}
                                        |{{ App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->landlord->email }}
                                    </li>
                                </ul>
                            @endif
                        @endif



                        @if ($invoice->category == 'Ingreso')
                            <br>
                            <h2>Arrendatario: {{ App\Models\Lease::whereId($invoice->lease_id)->first()->tenant_->name }}
                            </h2>
                            <ul>
                                <li><small>
                                        {{ App\Models\Lease::whereId($invoice->lease_id)->first()->tenant_->address }}</small>
                                </li>
                                <li>{{ App\Models\Lease::whereId($invoice->lease_id)->first()->tenant_->phone }}
                                    |{{ App\Models\Lease::whereId($invoice->lease_id)->first()->tenant_->email }}</li>
                            </ul>
                        @else
                            @if ($invoice->supplier)
                                <br>
                                <h2>Proveedor: {{ $invoice->supplier->name }}
                                </h2>
                                <ul>
                                    <li><small>
                                            {{ $invoice->supplier->comment }}</small>
                                    </li>

                                </ul>
                            @endif
                        @endif

                </div>


                <div>
                    <table>

                        <tr>
                            <th>Folio #</th>
                            <td style="text-align:center"> {{ $invoice->id }} </td>
                        </tr>
                        <tr>
                            <th>Fecha de Emisión</th>
                            <td style="text-align:center"> {{ $invoice->start_date }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Vencimiento</th>
                            <td style="text-align:center"> {{ $invoice->due_date }}</td>
                        </tr>
                        <tr>
                            <th>Régimen Fiscal</th>
                            <td style="text-align:center"> {{ $invoice->iva }}</td>
                        </tr>
                        <tr>
                            <th>Categoría</th>
                            <td style="text-align:center"> {{ $invoice->concept }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td style="text-align:center"> <small>{{ $invoice->type }}</small>
                                {{ Number::currency($invoice->ammount + $invoice->iva_ammount) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="inv-body">
                <table>
                    <thead>
                        <th style="text-align:center">Concepto</th>
                        <th style="text-align:center">Descripción</th>
                        <th style="text-align:center">Monto</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <h5> {{ $invoice->subconcept }}</h5>

                                @if ($invoice->lease_id == 1)
                                    <small> SIN CONTRATO ASOCIADO</small>
                                @else
                                    <a href="/leases/{{ $invoice->lease_id }} ">
                                        <small> VER CONTRATO ASOCIADO</small></a>
                                @endif


                            </td>
                            <td style="text-align:center"><i>{{ Str::limit($invoice->comment, 25) }}</i></td>
                            <td style="text-align:center"> <small>{{ $invoice->type }}</small>
                                {{ Number::currency($invoice->ammount) }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="inv-footer">
                <div>
                    {{-- <img src="/images/logo-demo.png" width="196" height="125" /> --}}
                    <img src="/images/logo-test.png" width="20%" height="20%" />

                </div>
                <div>
                    <table>
                        <tr>
                            <th>Sub total</th>
                            <td style="text-align:right"> <small>{{ $invoice->type }}</small>
                                {{ Number::currency($invoice->ammount) }}</td>
                        </tr>

                        @if ($invoice->iva == 'IVA_RETENCIONES')
                            <tr>
                                <th><span style="font-weight:normal">(+) IVA traslado <small>(16 %)</small></span></th>
                                <td style="text-align:right"> <small>{{ $invoice->type }}</small>
                                    {{ Number::currency($invoice->ammount * 0.16) }}</td>
                            </tr>
                            <tr>
                                <th><span style="font-weight:normal">(-) IVA retención <small>(10.667 %)</small></span></th>
                                <td style="text-align:right"> <small>{{ $invoice->type }}</small>
                                    {{ Number::currency($invoice->ammount * 0.10667) }}</td>
                            </tr>
                            <tr>
                                <th><span style="font-weight:normal">(-) ISR retención <small>(1.25 %)</small></span></th>
                                <td style="text-align:right"> <small>{{ $invoice->type }}</small>
                                    {{ Number::currency($invoice->ammount * 0.0125) }}</td>
                            </tr>
                        @else
                            <tr>
                                <th><span style="font-weight:normal">{{ $invoice->iva }} <small>({{ $invoice->iva_rate }}
                                            %)</small></span></th>
                                <td style="text-align:right"> <small>{{ $invoice->type }}</small>
                                    {{ Number::currency($invoice->iva_ammount) }}</td>
                            </tr>
                        @endif



                        <tr>
                            <th>Total</th>
                            <td style="text-align:right"> <small>{{ $invoice->type }}</small>
                                {{ Number::currency($invoice->total) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row no-print">


            </div>
            <br> <br>
            @if ($invoice->category == 'Ingreso')
                <label style="color:rgb(12, 3, 91)">
                    <small>Pagos (ingresos) registrados</small>
                </label>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:center"><small><b>Fecha</b></small></th>
                            <th scope="col" style="text-align:center"><small><b>Comentario</b></small></th>
                            <th scope="col" style="text-align:center"><small><b>Monto</b></small></th>
                            <th scope="col" style="text-align:center"><small><b>Ver [+]</b></small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->payments as $payment)
                            <tr>
                                <td style="text-align:center"><small>{{ $payment->date }}</small></td>
                                <td style="text-align:center"><small>{{ Str::limit($invoice->comment, 30) }} |
                                        {{ Str::limit($payment->comment, 30) }}</small></td>
                                <td style="text-align:center">
                                    <small>
                                        @if (is_null($payment->rate_exchange))
                                            {{ $payment->type }} {{ Number::currency($payment->ammount) }}
                                        @else
                                            {{ $payment->type }}
                                            {{ Number::currency($payment->ammount_exchange) }} /
                                            {{ $invoice->type }}
                                            {{ Number::currency($payment->ammount) }}
                                        @endif
                                    </small>
                                </td>
                                <td style="text-align:center">
                                    <small>
                                        <a href="/payments/{{ $payment->id }}" class="text-muted">
                                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </small>
                                </td>
                        @endforeach
                    </tbody>
                </table>
                <label style="color:rgb(15, 91, 3)">Total pagado: <small>{{ $invoice->type }}</small>
                    {{ Number::currency($invoice->payments->sum('ammount')) }}
                </label> /

                <label style="color:rgb(103, 103, 103)">Por pagar: <small>{{ $invoice->type }}</small>
                    {{ Number::currency($invoice->total - $invoice->payments->sum('ammount')) }}
                </label>
            @else
                <label style="color:rgb(12, 3, 91)">
                    <small>Pagos (egresos) registrados</small>
                </label>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:center"><small><b>Fecha</b></small></th>
                            <th scope="col" style="text-align:center"><small><b>Comentario</b></small></th>
                            <th scope="col" style="text-align:center"><small><b>Monto</b></small></th>
                            <th scope="col" style="text-align:center"><small><b>Ver [+]</b></small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->expenses as $expense)
                            <tr>
                                <td style="text-align:center"><small>{{ $expense->date }}</small></td>
                                <td style="text-align:center"><small>{{ Str::limit($invoice->comment, 30) }} |
                                        {{ Str::limit($expense->description, 30) }}</small></td>
                                <td style="text-align:center">
                                    <small>
                                        @if (is_null($expense->rate_exchange))
                                            {{ $expense->type }} {{ Number::currency($expense->ammount) }}
                                        @else
                                            {{ $expense->type }}
                                            {{ Number::currency($expense->ammount_exchange) }} /
                                            {{ $invoice->type }}
                                            {{ Number::currency($expense->ammount) }}
                                        @endif
                                    </small>
                                </td>
                                <td style="text-align:center">
                                    <small>
                                        <a href="/expenses/{{ $expense->id }}" class="text-muted">
                                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </small>
                                </td>
                        @endforeach
                    </tbody>
                </table>
                <small>
                    <label style="color:rgb(17, 126, 0)">Total pagado: <small>{{ $invoice->type }}</small>
                        {{ Number::currency($invoice->expenses->sum('ammount')) }}
                    </label> |

                    <label style="color:rgb(103, 103, 103)">Por pagar: <small>{{ $invoice->type }}</small>
                        {{ Number::currency($invoice->total - $invoice->expenses->sum('ammount')) }}
                    </label>
                </small>


                </ul>
            @endif

            <div class="row no-print">
                <div class="col-12">


                    <button type="button" onClick="location.href='/invoicepdf/{{ $invoice->id }}/'"
                        class="btn btn-danger float-right" style="margin-right: 5px;">
                        <i class="fas fa-download"></i> PDF
                    </button>


                    <button type="button" onClick="location.href='/invoicexml/{{ $invoice->id }}/'"
                        class="btn btn-success float-right" style="margin-right: 5px;">
                        <i class="far fa-file-excel"></i> XML
                    </button>

                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                    @can('edit')
                        <button type="button" onClick="location.href='/indexinvoices/{{ $invoice->id }}/edit/'"
                            class="btn btn-dark float-right" style="margin-right: 5px;">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    @endcan





                </div>

            </div>
        </div>


    </body>










@stop

@section('css')


@stop

@section('js')




@stop
