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


            <form method="POST" action="/indexproperties/{{ $property->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">


                    <div class="form-group">
                        <label for="building_id">Conjunto habitacional</label>
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
                        <input type="text" class="form-control" name="title" value="{{ $property->title }}">
                        @error('title')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida (avalúo)</label>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ $property->rent }}"">
                        @error('rent')
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

                        <textarea class="form-control" name="description" rows="3">{{ $property->description }}</textarea>
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
