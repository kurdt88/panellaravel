@extends('adminlte::page')

@section('title', 'Lista de Eventos del Sistema')


@section('content_header')
    <x-flash-message />


    <h1>Auditoria de Eventos del Sistema (Crear/Editar/Eliminar)
    </h1>


@stop




@section('content')

    @php
        $heads = ['Fecha & Hora', 'Usuario', 'Evento', 'Ver Mas'];
        $config = [
            'order' => [[0, 'desc']],
        ];
    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($logevents as $logevent)
            <tr>

                <td>


                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $logevent->created_at, 'UTC')->setTimezone('America/Mexico_City') }}


                </td>

                <td>
                    {{-- ({{ $logevent->user_id }}) --}}
                    {{ App\Models\User::where('id', $logevent->user_id)->get()->first()->name }}
                </td>
                <td>
                    <i class="fas fa-exclamation-triangle fa-fw"></i>

                    {{ Str::limit($logevent->event, 160) }}
                </td>
                <td>

                    <button type="button" onClick="javascript:alert('{{ $logevent->event }}')"
                        class="btn btn-success float-center" style="margin-center: 5px;">
                        <i class="fas fa-search"></i>
                    </button>
                </td>



            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
