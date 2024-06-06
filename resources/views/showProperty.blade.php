@extends('adminlte::page')

@section('title', 'Detalles de la Propiedad')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles de la Propiedad</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a href="/indexproperties/{{ $property->id }}/edit">Editar</a></li>
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
                        <h2><strong><i class="far fa fa-home">
                                    &ensp;</i>{{ $property->title }}</strong>
                            @if (count($property->subproperties) > 0)
                                <a href="/propertysubproperties/{{ $property->id }}">
                                    </label>
                                    <small>
                                        [+]
                                    </small>
                                </a>
                            @endif


                        </h2>
                        <p class="lead mb-5">
                            <i class='fas fa-map-marker-alt fa-sm'> </i>
                            {{ $property->location }}
                        </p>
                        </p>
                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">



                    </div>
                    <div class="form-group">

                        @if ($property->building_id != 1)
                            <label>Unidad Habitacional</label>

                            <a href="/buildings/{{ $property->building_id }}">
                                <label><small>[+ Ver Unidad Habitacional]</small></label>
                            </a>



                            <input type="text"
                                value="{{ App\Models\Building::whereId($property->building_id)->first()->name }}"
                                class="form-control" disabled />
                        @endif
                    </div>

                    <div class="form-group">

                        {{-- @if ($property->landlord_id != 1) --}}
                        <label>Propietario</label>

                        <a href="/landlords/{{ $property->landlord_id }}">
                            <label><small>[+ Ver Propietario]</small></label>
                        </a>

                        <input type="text"
                            value="{{ App\Models\Landlord::whereId($property->landlord_id)->first()->name }}"
                            class="form-control" disabled />
                        {{-- @endif --}}
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida (avalúo)</label>
                        <input type="text" value="{{ Number::currency($property->rent) }}" class="form-control"
                            disabled />
                    </div>
                    {{-- <div class="form-group">
                        <label for="inputSubject">Web</label>
                        <input type="text" value="{{ $property->website }}" class="form-control" disabled />
                    </div> --}}



                    @php
                        $myDescriptionArray = explode('&&&', $property->description);
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
                        <label for="inputMessage">Descripción de la propiedad</label>
                        <textarea class="form-control" rows="4" disabled>{{ $myDescription }}</textarea>
                    </div>



                    <div class="col-12">
                        <button type="button" onClick="location.href='/propertycommodities/{{ $property->id }}/'"
                            class="btn btn-success float-right" style="margin-right: 5px;">
                            <i class="fas fa-shopping-cart"></i> Ver Inventario
                        </button>

                        <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                            style="margin-right: 5px;">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        @can('edit')
                            <button onClick="location.href='/indexproperties/{{ $property->id }}/edit'" type="button"
                                class="btn btn-dark float-right" style="margin-right: 5px;">
                                <i class="fas fa-pen-alt"></i> Editar
                            </button>
                        @endcan
                        @if (count($property->subproperties) > 0)
                            <button type="button" onClick="location.href='/propertysubproperties/{{ $property->id }}'"
                                class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-warehouse"></i> Subunidades
                            </button>
                        @endif

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
            @foreach ($property->leases->sortBy('end_date')->reverse() as $lease)
                @if ($lease->subproperty_id == 1)
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
                @endif
            @endforeach

        </tbody>
    </table>




@stop

@section('css')
@stop

@section('js')

@stop
