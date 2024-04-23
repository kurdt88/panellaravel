@extends('adminlte::page')

@section('title', 'Panel de Inicio')

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
            <h3 class="card-title">Editar Propietario</h3>
        </div>


        <form method="POST" action="/indexlandlords/{{ $landlord->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Nombre</label>

                    <input type="text" class="form-control" name="name" value="{{ $landlord->name }}">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <div class="form-group">
                    <label>Dirección</label>

                    <input type="text" class="form-control" name="address" value="{{ $landlord->address }}"
                        placeholder="Dirección usada para Facturación">
                    @error('address')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" name="email" value="{{ $landlord->email }}">
                    @error('email')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" class="form-control" name="phone" value="{{ $landlord->phone }}">
                    @error('phone')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Información adicional</label>

                    <textarea class="form-control" name="comment" rows="3" placeholder="">{{ $landlord->comment }}</textarea>
                    @error('comment')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar Propietario</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
