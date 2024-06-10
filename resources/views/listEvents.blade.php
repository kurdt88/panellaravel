@extends('adminlte::page')

@section('title', 'Lista de Eventos del Sistema')


@section('content_header')
    <x-flash-message />


    <h1>Eventos del Sistema (Auditoria)
    </h1>


@stop




@section('content')

    @php
        $heads = ['ID', 'Fecha', 'Evento'];

    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="light" with-buttons striped hoverable>


        @foreach ($logevents as $logevent)
            <tr>
                <td>
                    <small>{{ $logevent->id }}</small>
                </td>
                <td>
                    <small>{{ $logevent->created_at }}</small>
                </td>

                {{-- <td>
                    ({{ $logevent->user_id }})
                    {{ App\Models\User::where('id', $logevent->user_id)->get()->first()->name }}
                </td> --}}
                <td>
                    <small>{{ $logevent->event }}</small>
                </td>


            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
