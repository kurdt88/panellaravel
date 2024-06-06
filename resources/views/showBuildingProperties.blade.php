@extends('adminlte::page')

@section('title', 'Lista de Propiedades')

@section('content_header')

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Propiedades en <strong>{{ $building->name }}</strong></h1>
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
                <div class="col-12">
                    <label>Lista de Propiedades:</i></label>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Último Contrato</th>
                                <th scope="col">Ver Mas</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($building->properties as $property)
                                <tr>
                                    <td>{{ $property->title }}<a href="/properties/{{ $property->id }}"> [+]</a>
                                    </td>
                                    <td>{{ Str::limit($property->location, 30) }}</td>
                                    <td>

                                        @php
                                            $lastLease = App\Models\Lease::where('property', $property->id)
                                                ->where('subproperty_id', 1)
                                                ->get()
                                                ->last();
                                        @endphp
                                        @if ($lastLease)
                                            <a href="/leases/{{ $lastLease->id }}">
                                                <i class='far fa-file-alt'> </i>
                                                </i>
                                            </a>
                                            <b>
                                                @if ($lastLease->isvalid == 4)
                                                    <font color="#006A4E">Por Iniciar</font>
                                                @elseif ($lastLease->isvalid == 2)
                                                    <font color="#413839">Cancelado</font>
                                                @elseif ($lastLease->isvalid == 3)
                                                    <font color="#FF6700">Vencido</font>
                                                @elseif ($lastLease->isvalid == 5)
                                                    <font color="#2B1B17">En Renovación</font>
                                                @elseif ($lastLease->isvalid == 1)
                                                    <font color="#12AD2B">Vigente</font>
                                                @endif
                                            </b>
                                        @else
                                            <font color="#888B90"><b>Sin Contrato</b></font>
                                        @endif
                                    </td>


                                    <td>
                                        <a href="/properties/{{ $property->id }}/" class="text-muted">
                                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">

                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>

        </div>
    </section>






@stop

@section('css')
@stop

@section('js')

@stop
