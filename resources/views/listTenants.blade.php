@extends('adminlte::page')

@section('title', 'Panel de Inicio')


@section('content_header')
    <x-flash-message />

    <h1>Lista de Arrendatarios<a href="/newtenant" class="btn btn-tool btn-sm">
            [Registrar Arrendatario] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a></h1>

@stop




@section('content')





    @php
        $heads = ['Nombre', 'Telefono', 'Email', '# Contratos Asociados', 'Acciones'];
        $config = [
            'order' => [[4, 'desc']],
        ];

    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($tenants as $tenant)
            @if ($tenant->id != 1)
                <tr>
                    <td>
                        <img src="/images/tenant-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        <a href="/tenants/{{ $tenant->id }}/" class="text-muted">
                            {{ $tenant->name }}
                        </a>
                    </td>
                    <td>{{ $tenant->phone }}</td>
                    <td>
                        {{ $tenant->email }}
                    </td>
                    <td>
                        {{ count($tenant->leases) }}
                    </td>
                    <div>
                        <td>
                            <a href="/tenants/{{ $tenant->id }}/" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>

                            <a href="/indextenants/{{ $tenant->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button> </a>

                            <form style="display:inline;" method="POST" action="/deltenant/{{ $tenant->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
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
