@extends('adminlte::page')

@section('title', 'Detalle del Ingreso')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Detalle del Ingreso</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a href="/indexpayments/{{ $payment->id }}/edit">Editar</a></li>
                        @endcan
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    <div class="invoice p-3 mb-3">

                        <div class="row">

                            <div class="col-12">
                                <h4>
                                    {{-- <i class="fas fa-globe"></i> Administración de Propiedades --}}
                                    <small class="float-right">Fecha:
                                        {{ $payment->created_at->format('d M Y') }}</small>
                                </h4>
                            </div>

                        </div>
                        <div>
                            {{-- <img src="/images/logo-demo.png" width="196" height="125" /> --}}
                            <img src="/images/logo-test.png" width="15%" height="15%" /><br>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <br>De
                                @if ($payment->lease_id == 1)

                                    @if ($payment->$invoice->subproperty_id)
                                        <address>
                                            <strong>{{ $payment->invoice->subproperty->landlord->name }}</strong><br>
                                            {{ $payment->invoice->subproperty->landlord->address }}<br>
                                            {{ $payment->invoice->subproperty->landlord->phone }}<br>
                                            {{ $payment->invoice->subproperty->landlord->email }}<br>
                                        </address>
                                    @else
                                        <address>
                                            <strong>{{ $payment->invoice->property->landlord->name }}</strong><br>
                                            {{ $payment->invoice->property->landlord->address }}<br>
                                            {{ $payment->invoice->property->landlord->phone }}<br>
                                            {{ $payment->invoice->property->landlord->email }}<br>
                                        </address>
                                    @endif
                                @else
                                    @if (App\Models\Lease::whereId($payment->lease_id)->first()->subproperty_id != 1)
                                        <address>
                                            <strong>{{ App\Models\Lease::whereId($payment->lease_id)->first()->subproperty->landlord->name }}</strong><br>
                                            {{ App\Models\Lease::whereId($payment->lease_id)->first()->subproperty->landlord->address }}<br>
                                            {{ App\Models\Lease::whereId($payment->lease_id)->first()->subproperty->landlord->phone }}<br>
                                            {{ App\Models\Lease::whereId($payment->lease_id)->first()->subproperty->landlord->email }}<br>
                                        </address>
                                    @else
                                        <address>
                                            <strong>{{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->name }}</strong><br>
                                            {{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->address }}<br>
                                            {{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->phone }}<br>
                                            {{ App\Models\Lease::whereId($payment->lease_id)->first()->property_->landlord->email }}<br>
                                        </address>
                                    @endif


                                @endif

                            </div>

                            <div class="col-sm-4 invoice-col">
                                <br>Para
                                <address>
                                    <strong>{{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->name }}</strong><br>
                                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->address }}<br>
                                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->phone }}<br>
                                    Email: {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->email }}</a>
                                </address>

                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Pago ID # {{ $payment->id }}</b><br>
                                <br>
                                <b>Contrato ID: </b>{{ $payment->lease_id }} <br>
                                <b>Fecha del pago: </b>{{ $payment->date }}<br>
                                <b>Propiedad: </b>
                                @if (App\Models\Lease::whereId($payment->invoice->lease_id)->first()->subpropertyname != '--')
                                    <a href="/subproperties/{{ $payment->invoice->lease->subproperty_id }}">
                                        {{ App\Models\Lease::whereId($payment->invoice->lease_id)->first()->subpropertyname }}</a><br>
                                @else
                                    <a
                                        href="/properties/{{ $payment->invoice->lease->property }}">{{ App\Models\Lease::whereId($payment->invoice->lease_id)->first()->property_->title }}</a><br>
                                @endif
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Monto</th>
                                            <th>Divisa de Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $payment->date }}</td>
                                            <td>{{ Str::limit($payment->invoice->concept, 35) }}
                                                | {{ Str::limit($payment->invoice->comment, 35) }} </td>
                                            <td>
                                                @if (is_null($payment->rate_exchange))
                                                    <small>{{ $payment->type }}</small>
                                                    {{ Number::currency($payment->ammount) }}
                                                @else
                                                    <small>{{ $payment->type }}</small>
                                                    {{ Number::currency($payment->ammount_exchange) }}
                                                @endif
                                            </td>
                                            <td>{{ $payment->type }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-6">
                                <p class="lead">Detalles:</p>
                                <small>
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Información Adicional: {{ $payment->comment }}
                                    </p>
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        @if ($payment->rate_exchange)
                                            Tipo de cambio: {{ $payment->rate_exchange }} <br>
                                            Monto en {{ $payment->invoice->type }}:
                                            {{ Number::currency($payment->ammount) }}<br>
                                        @endif

                                        Cuenta Bancaria en donde se reflejó el Pago:
                                        <a href="/accounts/{{ $payment->account->id }}">
                                            [{{ $payment->account->type }}]:
                                            {{ $payment->account->bank }} / Cuenta: {{ $payment->account->number }} |
                                            {{ $payment->account->owner }}
                                        </a>

                                    </p>
                                </small>
                            </div>

                            <div class="col-6">
                                {{-- <p class="lead">Fecha límite / / </p> --}}
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>
                                                @if (is_null($payment->rate_exchange))
                                                    <small>{{ $payment->type }}</small>
                                                    {{ Number::currency($payment->ammount) }}
                                                @else
                                                    <small>{{ $payment->type }}</small>
                                                    {{ Number::currency($payment->ammount_exchange) }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Total:</th>
                                            <td>
                                                @if (is_null($payment->rate_exchange))
                                                    <small>{{ $payment->type }}</small>
                                                    {{ Number::currency($payment->ammount) }}
                                                @else
                                                    <small>{{ $payment->type }}</small>
                                                    {{ Number::currency($payment->ammount_exchange) }}
                                                @endif

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>



                        <div class="row no-print">
                            <div class="col-12">

                                <button type="button" onClick="location.href='/invoices/{{ $payment->invoice_id }}/'"
                                    class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-book"></i> Ver Recibo
                                </button>

                                <button type="button" class="btn btn-danger float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> PDF
                                </button>
                                <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                                    style="margin-right: 5px;">
                                    <i class="fas fa-print"></i> imprimir
                                </button>
                                @can('edit')
                                    <button onClick="location.href='/indexpayments/{{ $payment->id }}/edit'" type="button"
                                        class="btn btn-dark float-right" style="margin-right: 5px;">
                                        <i class="fas fa-pen-alt"></i> Editar
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>




@stop

@section('css')
@stop

@section('js')

@stop
