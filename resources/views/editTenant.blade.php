@extends('adminlte::page')

@section('title', 'Editar Arrendatario')

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
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $tenant->name }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="name" value="{{ $tenant->name }}">
                        @error('name')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Domicilio</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $tenant->address }}</b>
                            </small></font>
                        <input type="text" min="1" step="any" class="form-control" name="address"
                            value="{{ $tenant->address }}"">
                        @error('address')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $tenant->email }}</b>
                            </small></font>
                        <input type="email" class="form-control" name="email" value="{{ $tenant->email }}">
                        @error('email')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $tenant->phone }}</b>
                            </small></font>
                        <input type="number" class="form-control" name="phone" value="{{ $tenant->phone }}">
                        @error('phone')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Información adicional</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $tenant->description }}</b>
                            </small></font>

                        <textarea class="form-control" name="description" rows="2"
                            placeholder="Incluye todos los detalles de la propiedad.">{{ $tenant->description }}</textarea>
                        @error('description')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Arrendatario</button>

                    <a href="javascript:history.back()" class="text-black ml-4"> Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop
