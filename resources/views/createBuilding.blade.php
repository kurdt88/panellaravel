@extends('adminlte::page')

@section('title', 'Panel de Inicio')

@section('content_header')
    <x-flash-error-message />
    <x-flash-message />



@stop

@section('content')

@section('plugins.BsCustomFileInput', true)

<header class="text-center">

</header>


<div class="col-md-12">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Crear nueva Unidad Habitacional</h3>
        </div>


        <form method="POST" action="/indexbuildings" enctype="multipart/form-data">
            @csrf
            <div class="card-body">



                <div class="form-group">
                    <label>Nombre de la Unidad</label>

                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                        placeholder="Ejemplo: Edificio Torre Portales, etc">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                        placeholder="Indique la dirección completa">
                    @error('address')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <x-adminlte-textarea name="description" label="Descripción" rows=5 label-class="text-dark"
                    igroup-size="sm" placeholder="Incluye todos los detalles de la Unidad Habitacional.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ old('description') }}
                </x-adminlte-textarea>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar Unidad Habitacional</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
