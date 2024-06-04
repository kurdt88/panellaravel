@extends('adminlte::page')

@section('title', 'Detalle del Contrato')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles de Movimientos (Recibos, Ingresos & Egresos)
                        <h6>
                            <label style="color:rgb(2, 110, 94)">
                                Inicio / Fin: {{ $lease->start }} /
                                @if ($lease->rescission)
                                    <label style="color:rgba(255, 1, 1, 0.798);"> Cancelado
                                    </label>
                                @else
                                    {{ $lease->end }}
                                @endif
                                | Renta:
                                {{ Number::currency($lease->rent) }} |
                                Arrendatario: {{ Str::limit($lease->tenant_->name, 30) }}
                            </label>
                        </h6>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:window.print()">Imprimir</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">



        <div class="card">
            <div class="card-body row">
                <div class="col-4">
                    <div>
                        <label><i>Pagos Realizados</i></label>

                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Comentario</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Ver Mas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lease->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->date }}</td>
                                        <td>{{ Str::limit($payment->invoice->comment, 10) }}</td>

                                        <td>
                                            @if (is_null($payment->rate_exchange))
                                                <small>{{ $payment->type }}</small>
                                                {{ Number::currency($payment->ammount) }}
                                            @else
                                                <small>{{ $payment->type }}</small>
                                                {{ Number::currency($payment->ammount_exchange) }} /
                                                <small>{{ $payment->invoice->type }}</small>
                                                {{ Number::currency($payment->ammount) }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/payments/{{ $payment->id }}" class="text-muted">
                                                <button class="btn btn-xs btn-default text-teal mx-1 shadow"
                                                    title="Details">
                                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-4">
                    <div class="form-group">


                        <label><i>Recibos emitidos</i></label>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Vence</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Ver Mas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lease->invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>
                                            <small>{{ $invoice->type }}</small>
                                            {{ Number::currency($invoice->total) }}
                                        </td>
                                        <td>
                                            @if ($invoice->category == 'Ingreso')
                                                @if ($invoice->ammount == 0)
                                                    <label style="color:rgb(90, 94, 96);">Excento Pago</label>
                                                @elseif ($invoice->balance == 0)
                                                    <label style="color:rgb(1, 109, 30);">Liquidado</label>
                                                @else
                                                    @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->start_date)->isFuture())
                                                        <label style="color:rgb(154, 155, 155);">Inactivo</label>
                                                    @else
                                                        @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->due_date)->isPast())
                                                            <label style="color:rgba(246, 2, 2, 0.398);">Vencido</label>
                                                        @else
                                                            <label style="color:rgb(198, 96, 0);">Por cobrar
                                                                <small> | {{ $invoice->category }}</small></label>
                                                        @endif
                                                    @endif
                                                @endif
                                            @else
                                                @if ($invoice->balance == 0)
                                                    <label style="color:rgb(1, 109, 30);">Liquidado</label>
                                                @else
                                                    @if ($invoice->balance == 0)
                                                        <label style="color:rgb(1, 109, 30);">Liquidado</label>
                                                    @else
                                                        @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->start_date)->isFuture())
                                                            <label style="color:rgb(154, 155, 155);">Inactivo</label>
                                                        @else
                                                            @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->due_date)->isPast())
                                                                <label style="color:rgba(246, 2, 2, 0.398);">Vencido</label>
                                                            @else
                                                                <label style="color:rgb(47, 60, 194);">Por Pagar
                                                                    <small>
                                                                        | {{ $invoice->category }}</small></label>
                                                            @endif
                                                        @endif
                                                        {{-- @endif --}}
                                                    @endif
                                                @endif

                                            @endif

                                        </td>
                                        <td>
                                            <a href="/invoices/{{ $invoice->id }}" class="text-muted">
                                                <button class="btn btn-xs btn-default text-teal mx-1 shadow"
                                                    title="Details">
                                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label><i>Gastos</i></label>

                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Comentario</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Ver Mas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lease->expenses as $expense)
                                    <tr>
                                        <td> {{ $expense->date }}</td>
                                        <td>{{ Str::limit($expense->invoice->comment, 5) }}</td>

                                        <td>
                                            @if (is_null($expense->rate_exchange))
                                                <small>{{ $expense->type }}</small>
                                                {{ Number::currency($expense->ammount) }}
                                            @else
                                                <small>{{ $expense->type }}</small>
                                                {{ Number::currency($expense->ammount_exchange) }} /
                                                <small>{{ $expense->invoice->type }}</small>
                                                {{ Number::currency($expense->ammount) }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/expenses/{{ $expense->id }}" class="text-muted">
                                                <button class="btn btn-xs btn-default text-teal mx-1 shadow"
                                                    title="Details">
                                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="col-12">

                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                    <button onClick="javascript:history.back()" type="button" class="btn btn-primary float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-reply"></i> Regresar
                    </button>
                </div>
            </div>
        </div>
    </section>






@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log('');
    </script>
@stop
