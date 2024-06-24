@extends('adminlte::page')

@section('title', 'Detalles de la Subunidad')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $subproperty->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles de la Subunidad</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a
                                    href="/indexsubproperties/{{ $subproperty->id }}/edit">Editar</a></li>
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
                        <h2><strong><i class="fas fa-warehouse">
                                </i> {{ Str::limit($subproperty->title, 22) }}</strong></h2>
                        <h3>
                            <i class='fas fa-map-marker-alt fa-sm'> </i><small> {{ $subproperty->address }} </small><br>
                            <small>Tipo: <i>{{ $subproperty->type }}</i></small>
                        </h3>
                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">



                    </div>
                    <div class="form-group">

                        @if ($subproperty->property_id != 1)
                            <label>Propiedad Asociada <a href="/properties/{{ $subproperty->property_id }}">
                                    [+]
                                </a></label>
                        @else
                            <label>Propiedad Asociada</label>
                        @endif


                        <input type="text"
                            value="{{ App\Models\Property::whereId($subproperty->property_id)->first()->title }}"
                            class="form-control" disabled />



                    </div>
                    <div class="form-group">

                        {{-- @if ($property->landlord_id != 1) --}}
                        <label>Propietario</label>

                        <a href="/landlords/{{ $subproperty->landlord_id }}">
                            <label>[+]</label>
                        </a>

                        <input type="text"
                            value="{{ App\Models\Landlord::whereId($subproperty->landlord_id)->first()->name }}"
                            class="form-control" disabled />
                        {{-- @endif --}}
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida (avalúo)</label>
                        <input type="text" value="{{ Number::currency($subproperty->rent) }}" class="form-control"
                            disabled />
                    </div>

                    @php
                        $myDescriptionArray = explode('&&&', $subproperty->description);
                    @endphp
                    @php
                        if (empty($myDescriptionArray[0])) {
                            $myDescription = '';
                        } else {
                            $myDescription = $myDescriptionArray[0];
                        }
                        if (empty($myDescriptionArray[1])) {
                            $myType = '';
                        } else {
                            $myType = $myDescriptionArray[1];
                        }

                    @endphp

                    <div class="form-group">
                        <label for="rent">Divisa</label>
                        <input type="text" value="{{ $myType }}" class="form-control" disabled />
                    </div>



                    <div class="form-group">
                        <label for="inputMessage">Descripción de la Subunidad</label>
                        <textarea class="form-control" rows="4" disabled>{{ $myDescription }}</textarea>
                    </div>
                    <button type="button" onClick="location.href='/subpropertyinvoicesnolease/{{ $subproperty->id }}/'"
                        class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-hand-holding-usd	"></i> Recibos sin Contrato
                    </button>
                    <div class="col-12">
                        <button type="button" onClick="location.href='/landlords/{{ $subproperty->landlord_id }}/'"
                            class="btn btn-success float-right" style="margin-right: 5px;">
                            <i class="far fa-id-badge"></i> Ver Propietario
                        </button>

                        @can('edit')
                            <button onClick="location.href='/indexsubproperties/{{ $subproperty->id }}/edit'" type="button"
                                class="btn btn-dark float-right" style="margin-right: 5px;">
                                <i class="fas fa-pen-alt"></i> Editar
                            </button>
                        @endcan

                        <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                            style="margin-right: 5px;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </section>



    <label style="color:rgb(12, 3, 91)">
        <small>Contratos registrados</small>
    </label>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col"><small><b>Estado</b></small></th>
                <th scope="col"><small><b>Fecha de Inicio/Fin</b></small></th>
                <th scope="col"><small><b>Renta</b></small></th>
                <th scope="col"><small><b>Régimen Fiscal</b></small></th>
                <th scope="col"><small><b>Arrendatario</b></small></th>
                <th scope="col"><small><b>Comentario</b></small></th>
                <th scope="col"><small><b>Ver [+]</b></small></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($subproperty->leases->sortBy('end_date')->reverse() as $lease)
                <tr>
                    <td>
                        <small>
                            <b>
                                @if ($lease->isvalid == 4)
                                    <font color="blue">Por Iniciar</font>
                                @elseif ($lease->isvalid == 2)
                                    <font color="red">Cancelado</font>
                                @elseif ($lease->isvalid == 3)
                                    <font color="gray">Vencido</font>
                                @elseif ($lease->isvalid == 5)
                                    <font color="#2B1B17">En Renovación</font>
                                @elseif ($lease->isvalid == 1)
                                    <font color="green">Vigente</font>
                                @endif
                            </b>
                        </small>
                    </td>


                    <td><small>{{ $lease->start }} / {{ $lease->end }}</small></td>
                    <td><small>{{ $lease->type }} {{ Number::currency($lease->rent) }}</td>
                    <td><small>{{ $lease->iva }}</small></td>

                    <td><small>{{ $lease->tenant_->name }}</small></td>

                    <td><small>{{ $lease->contract }}</small></td>


                    <td>
                        <small>
                            <a href="/leases/{{ $lease->id }}" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>
                        </small>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>


@stop

@section('css')
@stop

@section('js')

@stop
