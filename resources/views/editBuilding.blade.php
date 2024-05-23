@extends('adminlte::page')

@section('title', 'Editar Unidad Habitacional')

@section('content_header')
    <x-flash-error-message />

@stop

@section('content')

@section('plugins.BsCustomFileInput', true)

<header class="text-center">

</header>

<br>


<div class="col-md-12">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Unidad Habitacional: {{ $building->name }}</h3>
        </div>


        <form method="POST" action="/indexbuildings/{{ $building->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">



                <div class="form-group">
                    <label>Nombre de la Unidad</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $building->name }}</b>
                        </small></font>
                    <input type="text" class="form-control" name="name" value="{{ $building->name }}"
                        placeholder="Ejemplo: Edificio Torre Portales, etc">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $building->address }}</b>
                        </small></font>
                    <input type="text" class="form-control" name="address" value="{{ $building->address }}"
                        placeholder="Indique la dirección completa">
                    @error('address')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <label>Descripción</label>


                <font color="blue"><small><br>Valor actual:
                        <b>{{ $building->description }}</b>
                    </small></font>
                <x-adminlte-textarea name="description" rows=3 label-class="text-dark" igroup-size="sm"
                    placeholder="Incluye todos los detalles de la Unidad Habitacional.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ $building->description }}
                </x-adminlte-textarea>




            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar Unidad Habitacional</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
