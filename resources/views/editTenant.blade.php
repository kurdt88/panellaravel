@extends('adminlte::page')

@section('title', 'Panel de Inicio')

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
                <h3 class="card-title">Editar Arrendatario: {{ $tenant->name }}</h3>
            </div>


            <form method="POST" action="/indextenants/{{ $tenant->id }}"" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" value="{{ $tenant->name }}">
                        @error('name')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Domicilio</label>
                        <input type="text" min="1" step="any" class="form-control" name="address"
                            value="{{ $tenant->address }}"">
                        @error('address')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" value="{{ $tenant->email }}">
                        @error('email')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="number" class="form-control" name="phone" value="{{ $tenant->phone }}">
                        @error('phone')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Información adicional</label>

                        <textarea class="form-control" name="description" rows="3"
                            placeholder="Incluye todos los detalles de la propiedad.">{{ $tenant->description }}</textarea>
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
                    <button type="submit" class="btn btn-primary">Actualizar Arrendatario</button>

                    <a href="javascript:history.back()" class="text-black ml-4"> Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
        <link rel="stylesheet" href="/css/admin_custom.css">
    @stop






    {{-- @extends('adminlte::page')

@section('title', 'Panel de Inicio')

@section('content_header')
    <h1>Propiedades<b>LTE</b></h1>
    <x-flash-error-message />

@stop

@section('content')



    <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
            Editar Arrendatario: {{ $tenant->name }}
        </h2>
    </header>

    <form method="POST" action="/indextenants/{{ $tenant->id }}"" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="inline-block text-lg mb-2">Nombre</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name" value="{{ $tenant->name }}"
                placeholder="Nombre completo" />
            @error('name')
                <p class="text-red">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="address" class="inline-block text-lg mb-2">Domicilio</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="address"
                placeholder="Domicilio completo" value="{{ $tenant->address }}}" />
            @error('address')
                <p class="text-red">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="email" class="inline-block text-lg mb-2">Correo electrónico</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                placeholder="Ejemplo: Casa, campo, alberca, roofgarden" value="{{ $tenant->email }}" />
            @error('email')
                <p class="text-red">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="phone" class="inline-block text-lg mb-2">Teléfono</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="phone"
                placeholder="Ejemplo: Bacalar, BCS" value="{{ $tenant->phone }}" />
            @error('phone')
                <p class="text-red">{{ $message }}</p>
            @enderror
        </div>



        <div class="mb-6">
            <label for="description" class="inline-block text-lg mb-2">
                Información Adicional:
            </label>
            <br>
            <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                placeholder="Información adicional.">{{ $tenant->description }}</textarea>
            @error('description')
                <p class="text-red">{{ $message }}</p>
            @enderror
        </div>



        <div class="mb-6">
            <button class="bg-laravel text-black rounded py-2 px-4 hover:bg-black">
                Actualizar Arrendatario
            </button>

            <a href="/" class="text-black ml-4"> Back </a>
        </div>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}
