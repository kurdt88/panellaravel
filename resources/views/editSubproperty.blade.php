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


            <form method="POST" action="/indexsubproperties/{{ $subproperty->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="property_id">Propiedad Asociada</label>
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
                        <input type="text" class="form-control" name="title" value="{{ $subproperty->title }}">
                        @error('title')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control" name="address" value="{{ $subproperty->address }}">
                        @error('address')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida</label>
                        <input type="number" class="form-control" name="rent" value="{{ $subproperty->rent }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deposit">Depósito</label>
                        <input type="number" class="form-control" name="deposit" value="{{ $subproperty->deposit }}">
                        @error('deposit')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-adminlte-textarea name="description" label="Información de la Subunidad" rows=5
                        label-class="text-dark" igroup-size="sm">
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
