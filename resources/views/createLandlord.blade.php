@extends('adminlte::page')

@section('title', 'Crear nuevo Propietario')

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
            <h3 class="card-title">Crear nuevo Propietario</h3>
        </div>


        <form method="POST" action="/indexlandlords" enctype="multipart/form-data">
            @csrf
            <div class="card-body">



                <div class="form-group">
                    <label>Nombre o Razón Social</label>

                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                        placeholder="Como aparece en la Constancia de Situación Fiscal">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <div class="form-group">
                    <label>Dirección</label>

                    <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                        placeholder="Dirección usada para Facturación">
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
                        placeholder="Teléfono de contacto">
                    @error('phone')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Información adicional</label>

                    <textarea class="form-control" name="comment" rows="3" placeholder="">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar Propietario</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
