@extends('adminlte::page')

@section('title', 'Editar Concepto')

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
            <h3 class="card-title">Editar Concepto: {{ $concept->name }}</h3>
        </div>


        <form method="POST" action="/indexconcepts/{{ $concept->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">


                <div class="form-group">
                    <label for="type">Tipo</label><br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $concept->type }}</b>
                        </small></font>
                    <select name="type" class="custom-select rounded-0">
                        <option value="Ingreso">Ingreso</option>
                        <option value="Egreso">Egreso</option>

                        <option selected="selected">
                            {{ $concept->type }}
                        </option>
                    </select>
                    @error('type')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Concepto</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $concept->name }}</b>
                        </small></font>
                    <input type="text" class="form-control" name="name" value="{{ $concept->name }}">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>





            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar Concepto</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
