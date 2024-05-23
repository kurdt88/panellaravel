@extends('adminlte::page')


@section('title', 'Editar Subunidad')

@section('content_header')
    <x-flash-error-message />

@stop

@section('content')



    <header class="text-center">

    </header>

    <br>


    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editar Subunidad</h3>
            </div>

            <x-adminlte-modal id="modalinfo1" title="Lea esto antes de modificar este campo" theme="warning">
                No se recomienda la modificación de este campo, si ya existen Contratos, Recibos, Ingresos y/o Egresos
                asociados a esta Subunidad.
                <br><br>Al modificar este campo, automáticamente se asociará a la nueva Propiedad la información de esta
                Subunidad.
                <br><br>Si la Subunidad aún no tiene Contratos, Recibos, Ingresos y/o Egresos
                asociados, puede modificar este campo de manera
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

            <x-adminlte-modal id="modalinfo2" title="Lea esto antes de modificar este campo" theme="primary">
                Al generarse
                <br><br>Si la Propiedad aún no tiene Contratos, Recibos, Ingresos y/o Egresos asociados, puede modificar
                este campo de
                manera segura.
                <br><br>
            </x-adminlte-modal>

            <form method="POST" action="/indexsubproperties/{{ $subproperty->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="property_id">Propiedad Asociada</label>
                        <x-adminlte-button label="Alerta" theme="warning" data-toggle="modal" data-target="#modalinfo1" />
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>
                                    @if ($subproperty->property->id == 1)
                                        <font color="gray">{{ $subproperty->property->title }}</font>
                                    @else
                                        <a href="/properties/{{ $subproperty->property->id }}">
                                            {{ $subproperty->property->title }}
                                        </a>
                                    @endif
                                </b>
                            </small></font>
                        <select name="property_id" class="custom-select rounded-0" id="exampleSelectRounded0">
                            @foreach ($properties as $property)
                                @if ($property->id == $subproperty->property_id)
                                    <option value="{{ $property->id }}" selected>{{ $property->title }}</option>
                                @else
                                    <option value="{{ $property->id }}">{{ $property->title }}</option>
                                @endif
                            @endforeach

                        </select>

                    </div>
                    <div class="form-group">
                        <label for="landlord_id">Propietario</label>
                        <x-adminlte-button label="Alerta" theme="danger" data-toggle="modal" data-target="#modalinfo2" />

                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $subproperty->landlord->name }}</b>
                            </small></font>
                        <select name="landlord_id" class="custom-select rounded-0" id="landlord_id">
                            @foreach ($landlords as $landlord)
                                @if ($landlord->id != 1)
                                    @if ($landlord->id == $subproperty->landlord_id)
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
                        <label for="type">Tipo</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $subproperty->type }}</b>
                            </small></font>
                        <select name="type" class="custom-select rounded-0" id="exampleSelectRounded0">
                            <option value="Estacionamiento">Estacionamiento</option>
                            <option value="Bodega">Bodega</option>
                            <option value="Estudio">Estudio</option>
                            <option value="Depósito de Perro">Depósito de Perro</option>
                            <option value="Otro">Otro</option>
                            <option selected="selected">
                                {{ $subproperty->type }}
                            </option>
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tittle">Título</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $subproperty->title }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="title" value="{{ $subproperty->title }}">
                        @error('title')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $subproperty->address }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="address" value="{{ $subproperty->address }}">
                        @error('address')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ Number::Currency($subproperty->rent) }}</b>
                            </small></font>
                        <input type="number" class="form-control" name="rent" value="{{ $subproperty->rent }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <label for="deposit">Información de la Subunidad</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $subproperty->description }}</b>
                        </small></font>
                    <x-adminlte-textarea name="description" rows=5 label-class="text-dark" igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ $subproperty->description }}
                    </x-adminlte-textarea>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Subunidad</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

    @stop
