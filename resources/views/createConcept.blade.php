@extends('adminlte::page')

@section('title', 'Crear nueva Concepto')

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
            <h3 class="card-title">Crear nuevo Concepto</h3>
        </div>


        <form method="POST" action="/indexconcepts" enctype="multipart/form-data">
            @csrf
            <div class="card-body">





                <div class="form-group">
                    <label for="type">Tipo</label>
                    <select name="type" class="custom-select rounded-0">
                        <option value="Ingreso">Ingreso</option>
                        <option value="Egreso">Egreso</option>

                        <option selected="selected">
                            {{ old('type') }}
                        </option>
                    </select>
                    @error('type')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Concepto</label>

                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                        placeholder="Escriba el concepto que desee agregar">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>




            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar nuevo Concepto</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
