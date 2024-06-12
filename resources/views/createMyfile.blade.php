@extends('adminlte::page')

@section('title', 'Registrar Archivo')

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
            <h3 class="card-title">Registrar Archivo</h3>
        </div>


        <form method="POST" action="/indexmyfiles" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <label>Selecciona el archivo</label>

                <font color="blue"><small> * Máximo <b>2Mb</b> tamaño de archivo </small></font>

                <x-adminlte-input-file name="myfile" igroup-size="sm" placeholder="Choose a file..."
                    accept="application/pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx, .jpg, .png, .jpeg |image/*">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>


                <x-adminlte-textarea name="comment" label="Comentario" rows=1 label-class="text-dark" igroup-size="sm"
                    placeholder="Descripción del archivo.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ old('comment') }}
                </x-adminlte-textarea>


            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar Archivo</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
