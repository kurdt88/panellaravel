@extends('adminlte::page')

@section('title', 'Mostrando Arrendatario')

@section('content_header')


@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles del Arrendatario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        <li class="breadcrumb-item active"><a href="/indextenants/{{ $tenant->id }}/edit">Editar</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class>
                        <h2><strong><i class="far fa-user">
                                    &ensp;</i>{{ $tenant->name }}</strong></h2>
                        <p class="lead mb-1"><i class="fas fa-envelope fa-sm"></i> <small>{{ $tenant->email }}</small></p>
                        <p class="lead mb-1"><i class="fas fa-phone fa-sm"></i> <small>{{ $tenant->phone }}</small></p>

                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">
                        <label for="inputName">Dirección</label>
                        <input type="text" value="{{ $tenant->address }}" class="form-control" disabled />
                        <label for="inputMessage">Información Adicional</label>
                        <textarea class="form-control" rows="4" disabled>{{ $tenant->description }}</textarea>
                    </div>
                    <div class="col-12">
                        <label>Contrato(s) Asociado(s):</label>
                        <ul>
                            @foreach ($tenant->leases as $lease)
                                @if ($lease->property != 1 && $lease->subproperty_id == 1)
                                    <li><a href="/leases/{{ $lease->id }}">
                                            {{ App\Models\Property::whereId($lease->property)->first()->title }}</a>
                                @endif

                                @if ($lease->subproperty_id != 1)
                                    <li><a href="/leases/{{ $lease->id }}">
                                            {{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->title }}</a>
                                @endif
                                |
                                <small>
                                    <b>
                                        @if ($lease->isvalid == 4)
                                            <font color="blue">Por Iniciar</font>
                                        @elseif ($lease->isvalid == 2)
                                            <font color="red">Cancelado</font>
                                        @elseif ($lease->isvalid == 3)
                                            <font color="gray">Vencido</font>
                                        @elseif ($lease->isvalid == 1)
                                            <font color="green">Vigente</font>
                                        @endif
                                    </b>
                                </small>
                            @endforeach
                        </ul>


                        <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                            style="margin-right: 5px;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        <button type="button" onclick="location.href='/indextenants/{{ $tenant->id }}/edit'"
                            class="btn btn-dark float-right" style="margin-right: 5px;">
                            <i class="fas fa-pen-alt"></i> Editar
                        </button>
                    </div>

                </div>
            </div>
        </div>



        <label style="color:rgb(12, 3, 91)">
            <small>Pagos realizados</small>
        </label>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col"><small><b>Fecha</b></small></th>
                    <th scope="col"><small><b>Propiedad</b></small></th>
                    <th scope="col"><small><b>Monto</b></small></th>
                    <th scope="col"><small><b>Recibo Asociado</b></small></th>
                    <th scope="col"><small><b>Comentario</b></small></th>
                    <th scope="col"><small><b>Ver [+]</b></small></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenant->leases as $lease)
                    @foreach ($lease->payments as $payment)
                        <tr>
                            <td><small>{{ $payment->date }}</small></td>
                            <td>
                                <small>
                                    @if ($lease->property != 1 && $lease->subproperty_id == 1)
                                        <li><a href="/leases/{{ $lease->id }}">
                                                {{ App\Models\Property::whereId($lease->property)->first()->title }}</a>
                                    @endif

                                    @if ($lease->subproperty_id != 1)
                                        <li><a href="/leases/{{ $lease->id }}">
                                                {{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->title }}</a>
                                    @endif
                                </small>
                            </td>

                            <td>
                                <small>
                                    @if (is_null($payment->rate_exchange))
                                        {{ $payment->type }} {{ Number::currency($payment->ammount) }}
                                    @else
                                        {{ $payment->type }}
                                        {{ Number::currency($payment->ammount_exchange) }} /
                                        {{ $payment->invoice->type }}
                                        {{ Number::currency($payment->ammount) }}
                                    @endif
                                </small>
                            </td>

                            <td><small>
                                    <a href="/invoices/{{ $payment->invoice->id }}/" class="text-muted">
                                        {{ $payment->invoice->concept }}
                                    </a>
                                </small>
                            </td>
                            <td><small>{{ Str::limit($payment->invoice->comment, 45) }}</small></td>

                            <td>
                                <small>
                                    <a href="/payments/{{ $payment->id }}" class="text-muted">
                                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </button>
                                    </a>
                                </small>
                            </td>
                    @endforeach
                @endforeach

            </tbody>
        </table>

    </section>






@stop

@section('css')
@stop

@section('js')

@stop
