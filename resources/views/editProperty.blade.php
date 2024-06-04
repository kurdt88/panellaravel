@extends('adminlte::page')

@section('title', 'Editar Unidad')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />

@stop

@section('content')



    <header class="text-center">
        {{-- <h2 class="text-2xl font-bold uppercase mb-1">
            Crear una nueva propiedad
        </h2> --}}
    </header>

    <br>


    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editar Unidad: {{ $property->title }}</h3>
            </div>


            <x-adminlte-modal id="modalinfo1" title="Lea esto antes de modificar este campo" theme="warning">
                No se recomienda la modificación de este campo, si ya existen Egresos que afectaron al Presupuesto de
                Mantenimiento de la Unidad Habitacional actualmente asociada.
                <br><br>Al modificar este campo, automáticamente se transferiran a la nueva Unidad Habitacional todos los
                Egresos asociados con la Propiedad.
                <br><br>Si la Propiedad aún no tiene este tipo de Egresos asociados, puede modificar este campo de manera
                segura.
                <br><br>
            </x-adminlte-modal>

            <x-adminlte-modal id="modalinfo2" title="Lea esto antes de modificar este campo" theme="danger">
                No se recomienda la modificación de este campo, si ya existen Contratos, Recibos, Ingresos y/o Egresos en el
                sistema.
                <br><br>Al modificar este campo, automáticamente se transferirán al nuevo Propietario todos los Contratos,
                Recibos,
                Ingresos y/o Egresos que existan registrados en el sistema.
                <br><br>Esto <b>afectaría la consistencia de la información histórica del sistema</b>, relacionada con los
                estados
                de cuenta asociados al anterior y nuevo Propietario.
                <br><br>Si la Propiedad aún no tiene Contratos, Recibos, Ingresos y/o Egresos asociados, puede modificar
                este campo de
                manera segura.
                <br><br>
            </x-adminlte-modal>


            <form method="POST" action="/indexproperties/{{ $property->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">


                    <div class="form-group">

                        <label for="building_id">Conjunto habitacional</label>
                        <x-adminlte-button label="Alerta" theme="warning" data-toggle="modal" data-target="#modalinfo1" />
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $property->building->name }}</b>
                            </small></font>
                        <select name="building_id" class="custom-select rounded-0" id="exampleSelectRounded0">
                            @foreach ($buildings as $building)
                                @if ($building->id == $property->building_id)
                                    <option value="{{ $building->id }}" selected>{{ $building->name }}</option>
                                @else
                                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                                @endif
                            @endforeach


                        </select>
                        @error('building_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="landlord_id">Propietario</label>
                        <x-adminlte-button label="Alerta" theme="danger" data-toggle="modal" data-target="#modalinfo2" />

                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $property->landlord->name }}</b>
                            </small></font>
                        <select name="landlord_id" class="custom-select rounded-0" id="landlord_id">
                            @foreach ($landlords as $landlord)
                                @if ($landlord->id != 1)
                                    @if ($landlord->id == $property->landlord_id)
                                        <option value="{{ $landlord->id }}" selected>{{ $landlord->name }}</option>
                                    @else
                                        <option value="{{ $landlord->id }}">{{ $landlord->name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                        @error('landlord_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tittle">Título</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $property->tite }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="title" value="{{ $property->title }}">
                        @error('title')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida (avalúo)</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ Number::Currency($property->rent) }}</b>
                            </small></font>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ $property->rent }}"">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

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
                        <label for="type">Divisa</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $myType }}</b>
                            </small></font>
                        <select name="type" class="custom-select rounded-0">
                            <option value="">-- Selecciona un Divisa --</option>
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>


                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label for="tags">Etiquetas</label>
                        <input type="text" class="form-control" name="tags" value="{{ $property->tags }}">
                        @error('tags')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="location">Ubicación</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $property->location }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="location" value="{{ $property->location }}">
                        @error('location')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label for="website">WebSite</label>
                        <input type="text" class="form-control" name="website" value="{{ $property->website }}">
                        @error('website')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="description">Descripción de la propiedad</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $myDescription }}</b>
                            </small></font>
                        <textarea class="form-control" name="description" rows="3">{{ $myDescription }}</textarea>
                        @error('description')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Unidad</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar </a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop
