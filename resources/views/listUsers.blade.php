@extends('adminlte::page')

@section('title', 'Lista de Usuarios')


@section('content_header')
    <x-flash-message />

    <h1>Lista de Usuarios</h1>

@stop




@section('content')





    @php
        $heads = ['Nombre', 'Email', 'Rol', 'Acciones'];
        $config = [
            'order' => [[1, 'desc']],
        ];

    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($users as $user)
            @if ($user->id != 1)
                <tr>
                    <td>
                        <img src="/images/user-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        @if (count($user->getRoleNames()) > 0)
                            @foreach ($user->getRoleNames() as $role)
                                <strong>{{ $role }} </strong>
                            @endforeach
                        @else
                            Sin Asignar
                        @endif

                    </td>
                    <div>
                        <td>


                            <a href="/indexusers/{{ $user->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button> </a>

                            <form style="display:inline;" method="POST" action="/deluser/{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="return confirm('¿Estas seguro de querer borrar al Usuario <<{{ $user->name }}>> ? \n ALERTA Si confirma no se podrá recuperar la información.')">

                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </div>
                </tr>
            @endif
        @endforeach


    </x-adminlte-datatable>


@stop

@section('css')
@stop
