@extends('adminlte::page')

@section('title', 'Editar Proveedor')

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
            <h3 class="card-title">Editar Proveedor</h3>
        </div>


        <form method="POST" action="/indexsuppliers/{{ $supplier->id }}"" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre del Proveedor</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $supplier->name }}</b>
                        </small></font>
                    <input type="text" class="form-control" name="name" value="{{ $supplier->name }}"
                        placeholder="Razón social, etiqueta o nombre corto">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $supplier->email }}</b>
                        </small></font>
                    <input type="email" class="form-control" name="email" value="{{ $supplier->email }}">
                    @error('email')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $supplier->phone }}</b>
                        </small></font>
                    <input type="number" class="form-control" name="phone" value="{{ $supplier->phone }}">
                    @error('phone')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <label for="phone">Descripción del Servicio</label>
                <br>
                <font color="blue"><small>Valor actual:
                        <b>{{ $supplier->comment }}</b>
                    </small></font>
                <x-adminlte-textarea name="comment" rows=2 label-class="text-dark" igroup-size="sm">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ $supplier->comment }}
                </x-adminlte-textarea>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Editar Proveedor</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
