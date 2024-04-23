@extends('adminlte::page')

@section('title', 'Panel de Inicio')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')



    <header class="text-center">
        {{-- <h2 class="text-2xl font-bold uppercase mb-1">
            Crear una nueva propiedad
        </h2> --}}
    </header>



    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crear nuevo Arrendatario</h3>
            </div>


            <form method="POST" action="/indextenants" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre o Razón Social</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                            placeholder="Como aparece en la Constancia de Situación Fiscal">
                        @error('name')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Domicilio</label>
                        <input type="text" min="1" step="any" class="form-control" name="address"
                            value="{{ old('address') }}">
                        @error('address')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="number" class="form-control" name="phone" value="{{ old('phone') }}"
                            placeholder="Dirección completa">
                        @error('phone')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Información adicional</label>

                        <textarea class="form-control" name="description" rows="3"
                            placeholder="Incluye todos los detalles de la propiedad.">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="exampleInputFile">Imagen del arrendatario</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div> --}}

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Arrendatario</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop
