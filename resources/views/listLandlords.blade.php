@extends('adminlte::page')

@section('title', 'Lista de Propietarios')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Propietarios <a href="/newlandlord" class="btn btn-tool btn-sm">
            [Nuevo Propietario] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a> </h1>

@stop




@section('content')


    @php
        $heads = ['Nombre', 'Correo', '# Propiedades', '# Subunidades', '# Cuentas Bancarias', 'Acciones'];
        $config = [
            'order' => [[0, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($landlords as $landlord)
            @if ($landlord->id != 1)
                <tr>
                    <td>
                        <img src="/images/landlord-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        {{ Str::limit($landlord->name, 25) }}
                    </td>
                    <td>
                        {{ $landlord->email }}
                    </td>
                    <td> {{ count($landlord->properties) }}</td>
                    <td>
                        {{ count($landlord->subproperties) }}
                    </td>
                    <td>
                        {{ count($landlord->accounts) }}
                    </td>
                    <div>
                        <td>
                            <a href="/landlords/{{ $landlord->id }}/" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>

                            <a href="/indexlandlords/{{ $landlord->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button> </a>

                            <form style="display:inline;" method="POST" action="/dellandlord/{{ $landlord->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="return confirm('¿Estas seguro de querer borrar el registro seleccionado? \n ALERTA Si confirma la información no podrá ser recuperada.')">

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
