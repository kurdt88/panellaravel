@extends('adminlte::page')

@section('title', 'Editar Archivo')

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
            <h3 class="card-title">Editar Archivo: <strong>{{ $myfile->original_name }}</strong></h3>
        </div>


        <form method="POST" action="/indexmyfiles/{{ $myfile->id }}"" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <label for="phone">Comentario</label>
            <br>
            <font color="blue"><small>Valor actual:
                    <b>{{ $myfile->comment }}</b>
                </small></font>
            <x-adminlte-textarea name="comment" rows=2 label-class="text-dark" igroup-size="sm">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-secondary">
                        <i class="fas fa-lg fa-file-alt text-light"></i>
                    </div>
                </x-slot>
                {{ $myfile->comment }}
            </x-adminlte-textarea>



    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Editar Archivo</button>

        <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
    </div>
    </form>
</div>





@stop

@section('css')
@stop

@section('js')

@stop
