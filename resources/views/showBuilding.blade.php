@extends('adminlte::page')

@section('title', 'Detalle de la Unidad Habitacional')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalle de la Unidad Habitacional</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a href="/indexbuildings/{{ $building->id }}/edit">Editar</a></li>
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
                        <h2><strong> <i class="far fa-building fa-fw">
                                </i>
                                {{ $building->name }}

                            </strong><a href="/buildingproperties/{{ $building->id }}">
                                <small>
                                    [+]
                                </small>
                        </h2>

                        </a>
                        <p class="lead mb-5">
                            <i class='fas fa-map-marker-alt fa-sm'> </i>
                            {{ $building->address }}
                        </p>

                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">

                        <label>Título</label>
                        <input type="text" value="{{ $building->name }}" class="form-control" disabled />

                        <label># Propiedades</label>
                        <input type="text" value=" {{ count($building->properties) }}" class="form-control" disabled />



                        {{-- <label for="inputName">Presupuesto Mtto (MXN)</label>
                        <input type="text" value=" {{ Number::currency($building->maintenance_budget) }}"
                            class="form-control" disabled />


                        <label for="inputName">Presupuesto Mtto (USD)</label>
                        <input type="text" value=" {{ Number::currency($building->maintenance_budget_usd) }}"
                            class="form-control" disabled /> --}}


                        <label for="inputMessage">Descripción</label>
                        <textarea class="form-control" rows="4" disabled>{{ $building->description }}</textarea>
                    </div>
                </div>

                <div class="col-12">


                    <button type="button" onClick="location.href='/buildingproperties/{{ $building->id }}'"
                        class="btn btn-success float-right" style="margin-right: 5px;">
                        <i class="fas fa-building"></i> Ver Propiedades
                    </button>


                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                    <button type="button" onClick="location.href='/buildingmaintenanceexpenses/{{ $building->id }}'"
                        class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-coins"></i> Afectaciones al Presupuesto de Mtto
                    </button>
                    <button type="button" onClick="location.href='/buildingbudgets/{{ $building->id }}'"
                        class="btn btn-secondary float-right" style="margin-right: 5px;">
                        <i class="fas fa-coins"></i> Presupuestos de Mtto
                    </button>
                    @can('edit')
                        <button type="button" onClick="location.href='/indexbuildings/{{ $building->id }}/edit'"
                            class="btn btn-dark float-right" style="margin-right: 5px;">
                            <i class="fas fa-pen-alt"></i> Editar
                        </button>
                    @endcan

                </div>
            </div>
        </div>






    </section>






@stop

@section('css')
@stop

@section('js')

@stop
