@extends('adminlte::page')

@section('title', 'Detalle del Proveedor')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalle del Proveedor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a href="/indexsuppliers/{{ $supplier->id }}/edit">Editar</a></li>
                        @endcan
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
                        <h2><strong> <i class="far fa-address-card">
                                </i>
                                {{ $supplier->name }}

                            </strong><a href="/suppliers/{{ $supplier->id }}">
                                <small>
                                    [+]
                                </small>
                        </h2>

                        </a>
                        <p class="lead mb-1"><i class="fas fa-envelope fa-sm"></i> <small>{{ $supplier->email }}</small></p>
                        <p class="lead mb-1"><i class="fas fa-phone fa-sm"></i> <small>{{ $supplier->phone }}</small></p>

                        <p class="lead mb-5">
                            Registrado desde: {{ $supplier->created_at->format('d M Y') }}

                        </p>
                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">

                        <label for="inputName">Nombre</label>
                        <input type="text" value=" {{ $supplier->name }}" class="form-control" disabled />



                        <label for="inputMessage">Información Adicional</label>
                        <textarea class="form-control" rows="3" disabled>{{ $supplier->comment }}</textarea>
                        <br>

                        <a href="/supplierpayments/{{ $supplier->id }}/" rel="noopener"
                            class="btn btn-success float-right"><i class="fas fa-hand-holding-medical"></i> Ver Pagos y
                            Recibos</a> &nbsp;
                        <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                            style="margin-right: 5px;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        @can('edit')
                            <button type="button" onclick="location.href='/indexsuppliers/{{ $supplier->id }}/edit'"
                                class="btn btn-dark float-right" style="margin-right: 5px;">
                                <i class="fas fa-pen-alt"></i> Editar
                            </button>
                        @endcan
                    </div>
                </div>

            </div>

            {{-- <label>Pagos registrados a favor de este proveedor:</label>
            <ul>
                @foreach ($supplier->expenses as $expense)
                    <li><a href="/expenses/{{ $expense->id }}">[+]</a>
                        {{ $expense->date }}&nbsp;&nbsp;&nbsp;&nbsp;

                        <small>{{ $expense->type }}</small>
                        {{ Number::currency($expense->ammount) }}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Str::limit($expense->description, 25) }}
                @endforeach
            </ul> --}}


        </div>







    </section>






@stop

@section('css')
@stop

@section('js')

@stop
