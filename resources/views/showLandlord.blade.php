@extends('adminlte::page')

@section('title', 'Detalles del Propietario')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles del Propietario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a href="/indexlandlords/{{ $landlord->id }}/edit">Editar</a></li>
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
                        <h2><strong> <i class="fas fa-user-tie fa-fw"">
                                </i>
                                {{ $landlord->name }}

                            </strong>
                        </h2>

                        <p class="lead mb-1"><i class="fas fa-phone fa-sm"></i>
                            <small>{{ $landlord->phone }}</small>
                        </p>
                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">

                        <label>Correo</label>
                        <input type="text" value="{{ $landlord->email }}" class="form-control" disabled />
                        <label>Teléfono</label>
                        <input type="text" value="{{ $landlord->phone }}" class="form-control" disabled />
                        <label>Dirección de facturación</label>
                        <input type="text" value="{{ $landlord->address }}" class="form-control" disabled />



                        <label for="inputMessage">Información Adicional</label>
                        <textarea class="form-control" rows="4" disabled>{{ $landlord->comment }}</textarea>

                        <br>

                        <a href="/landlorditems/{{ $landlord->id }}" rel="noopener" class="btn btn-success float-right"><i
                                class="fas fa-coins"></i> Cuentas ($) & Propiedades</a> &nbsp;
                        <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                            style="margin-right: 5px;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        @can('edit')
                            <button type="button" onclick="location.href='/indexlandlords/{{ $landlord->id }}/edit'"
                                class="btn btn-dark float-right" style="margin-right: 5px;">
                                <i class="fas fa-pen-alt"></i> Editar
                            </button>
                        @endcan
                    </div>
                </div>

            </div>
        </div>


        {{-- <div class="col-7">
            <label>Propiedad(es) Registradas(s):</label>
            <ul>
                @foreach ($landlord->properties as $property)
                    <li><a href="/properties/{{ $property->id }}">
                            {{ App\Models\Property::whereId($property->id)->first()->title }}</a>
                @endforeach
            </ul>

        </div> --}}




    </section>






@stop

@section('css')
@stop

@section('js')

@stop
