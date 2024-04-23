@extends('adminlte::page')

@section('title', 'Panel de Inicio')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalles del Contrato</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:window.print()"> Imprimir</a></li>
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
                        {{-- Caso 1: Contrato de una propiedad --}}
                        @if ($lease->property != 1 && $lease->subproperty_id == 1)
                            <h2><strong> <i class="far fa-handshake">
                                        &ensp;</i>{{ Str::limit(App\Models\Property::whereId($lease->property)->first()->title, 25) }}
                                </strong>
                                <a href="/properties/{{ App\Models\Lease::where('id', $lease->id)->first()->property }}">
                                    <small>
                                        [+]
                                    </small>
                                </a>
                            </h2>

                            <p class="lead mb-5">
                                <i class='fas fa-map-marker-alt fa-sm'> </i>
                                {{ App\Models\Property::whereId($lease->property)->first()->location }}
                            </p>
                        @endif

                        {{-- Caso 2: Contrato de una subpropiedad asociada a una propiedad --}}
                        @if ($lease->property != 1 && $lease->subproperty_id != 1)
                            <h2><strong> <i class="far fa-handshake">
                                        &ensp;</i>{{ Str::limit(App\Models\Subproperty::whereId($lease->subproperty_id)->first()->title, 25) }}
                                </strong>
                                <a href="/subproperties/{{ $lease->subproperty_id }}">
                                    <small>
                                        [+]
                                    </small>
                                </a>

                            </h2>
                            <p class="lead mb-1">

                                Tipo de Subunidad:
                                {{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->type }}

                            </p>
                            <p class="lead mb-5">
                                <i>{{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->address }}</i>
                            </p>

                            <h5><strong> Propiedad Asociada:
                                    <a
                                        href="/properties/{{ $lease->property }}">{{ Str::limit(App\Models\Property::whereId($lease->property)->first()->title, 25) }}</a>
                                </strong>

                            </h5>
                        @endif


                        {{-- Caso 3: Contrato de una subpropiedad SIN una propiedad asociada --}}
                        @if ($lease->property == 1 && $lease->subproperty_id != 1)
                            <h2><strong> <i class="far fa-handshake">
                                        &ensp;</i>{{ Str::limit(App\Models\Subproperty::whereId($lease->subproperty_id)->first()->title, 25) }}
                                </strong>
                                <a href="/subproperties/{{ $lease->subproperty_id }}">
                                    <small>
                                        [+]
                                    </small>
                                </a>

                            </h2>

                            <p class="lead mb-1">

                                Tipo de Subunidad:
                                {{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->type }}

                            </p>
                            <p class="lead mb-5">
                                <i>{{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->address }}</i>
                            </p>
                        @endif




                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">


                        <label>Propietario</label>


                        @if ($lease->subproperty_id != 1)
                            <a href="/landlords/{{ $lease->subproperty->landlord_id }}">
                                [+ Ver Propietario]
                            </a>
                            <input type="text" value="{{ $lease->subproperty->landlord->name }}" class="form-control"
                                disabled />
                        @else
                            <a href="/landlords/{{ $lease->property_->landlord_id }}">
                                [+ Ver Propietario]
                            </a>
                            <input type="text" value="{{ $lease->property_->landlord->name }}" class="form-control"
                                disabled />
                        @endif



                        <label>Arrendatario</label>
                        <a href="/tenants/{{ $lease->tenant_->id }}">
                            [+ Ver Arrendatario]
                        </a>
                        <input type="text" value="{{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}"
                            class="form-control" disabled />


                        <label for="inputName">Régimen Fiscal</label>
                        <input type="text" value="{{ $lease->iva }} ({{ $lease->iva_rate }} %)" class="form-control"
                            disabled />

                        <label for="inputName">Divisa</label>
                        <input type="text" value="$ {{ $lease->type }}" class="form-control" disabled />

                        <label for="inputName">Renta Mensual</label>
                        <input type="text" value=" {{ Number::currency($lease->rent) }}" class="form-control"
                            disabled />

                        <label for="inputName">Depósito</label>
                        <input type="text" value=" {{ Number::currency($lease->deposit) }}" class="form-control"
                            disabled />

                        <label for="inputName">Fecha Inicio/Fin</label>
                        <input type="text" value="{{ $lease->start }} / {{ $lease->end }}" class="form-control"
                            disabled />

                        <label for="inputMessage">Información Adicional</label>
                        <textarea class="form-control" rows="1" disabled>{{ $lease->contract }}</textarea>
                    </div>




                    <?php $isvalid = $lease->isvalid; ?>


                    @if ($isvalid == 2)
                        <?php $myrescission = $lease->rescission; ?>
                        <x-adminlte-callout theme="danger" title-class="text-danger text-uppercase"
                            icon="fas fa-handshake-slash" title="ESTE CONTRATO FUE CANCELADO DE MANERA ANTICIPADA">
                            Se pueden <a href="/leasemovements/{{ $lease->id }}">consultar los Recibos, Ingresos y
                                Egresos relacionados con este Contrato</a> por medio del botón "Ver Movimientos".
                            <br><br> Asimismo, el sistema da la posibilidad de Liquidar los Recibos que
                            hubieran
                            quedado pendientes al momento de la cancelacion de este Contrato.</i>
                            <br><br>
                            Fecha y Motivo de cancelación: <label>{{ $myrescission->date_start }} |
                                {{ $myrescission->reason }}</label>
                        </x-adminlte-callout>
                    @elseif ($isvalid == 3)
                        <x-adminlte-callout theme="secondary" title-class="text-secondary text-uppercase"
                            icon="far fa-calendar-times" title="ESTE CONTRATO YA VENCIÓ">
                            Se pueden <a href="/leasemovements/{{ $lease->id }}">consultar los Recibos, Ingresos y
                                Egresos relacionados con este Contrato</a> por medio del botón "Ver Movimientos".
                            <br><br> Asimismo, el sistema da la posibilidad de Liquidar los Recibos que
                            hubieran
                            quedado pendientes al vencimiento de este Contrato.</i>
                            <br><br>

                        </x-adminlte-callout>
                    @elseif ($isvalid == 4)
                        <x-adminlte-callout theme="info" title-class="text-primary text-uppercase" icon="far fa-clock"
                            title="ESTE CONTRATO AÚN NO INICIA">
                            Se debe esperar a que inicie su vigencia para poder hacer operaciones con este Contrato.</i>
                            <br><br>

                        </x-adminlte-callout>
                    @elseif ($isvalid == 1)
                        <x-adminlte-callout theme="success" title-class="text-success" icon="far fa-handshake"
                            title="Contrato Vigente">

                        </x-adminlte-callout>
                        <button type="button" theme="outline-danger" class="btn btn-outline-danger float-right"
                            onClick="location.href='/cancellease/{{ $lease->id }}/'" style="margin-right: 5px;">
                            <i class="fas fa-handshake-slash"></i> Rescisión del Contrato
                        </button>
                        <button type="button" onClick="location.href='/indexleases/{{ $lease->id }}/edit'"
                            class="btn btn-dark float-right" style="margin-right: 5px;">
                            <i class="fas fa-pen-alt"></i> Editar
                        </button>
                    @endif
                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> imprimir
                    </button>
                    <button type="button" onclick="location.href='/leasemovements/{{ $lease->id }}'"
                        class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-calendar"></i> Ver Movimientos
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
