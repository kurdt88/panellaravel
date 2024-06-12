@extends('adminlte::page')

@section('title', 'Lista de Archivos')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Archivos
        @can('create')
            <a href="/newmyfile" class="btn btn-tool btn-sm">
                [Registrar Archivo] <button class="btn btn-link"><i class="fas fa-plus"></i></button>
            </a>
        @endcan
    </h1>


@stop




@section('content')

    @php
        $heads = ['Archivo', 'Comentario', 'Registrado por', 'Fecha de Registro', 'Acciones'];

    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="light" with-buttons striped hoverable>


        @foreach ($myfiles as $myfile)
            <tr>
                <td>
                    <i class="far fa-file fa-fw"></i>
                    {{ $myfile->original_name }}
                </td>

                <td>{{ Str::limit($myfile->comment, 25) }}</td>
                <td>
                    {{-- ({{ $logevent->user_id }}) --}}
                    {{ App\Models\User::where('id', $myfile->user_id)->get()->first()->name }}
                </td>
                <td> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myfile->created_at, 'UTC')->setTimezone('America/Mazatlan') }}
                </td>

                <div>
                    <td>


                        <a href="https://propertiesspace.sfo3.digitaloceanspaces.com/{{ $myfile->file }}" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>

                        @can('edit')
                            <a href="/indexmyfiles/{{ $myfile->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button> </a>
                        @endcan

                        @can('delete')
                            <form style="display:inline;" method="POST" action="/delmyfile/{{ $myfile->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="return confirm('¿Estas seguro de querer borrar el registro <<{{ $myfile->original_name }}>> ? \n ALERTA Si confirma no se podrá recuperar la información.')">
                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </td>
                </div>
            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
