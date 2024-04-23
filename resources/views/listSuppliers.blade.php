@extends('adminlte::page')

@section('title', 'Panel de Inicio')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Proveedores<a href="/newsupplier" class="btn btn-tool btn-sm">
            [Nuevo Proveedor] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a></h1>

@stop




@section('content')

    @php
        $heads = ['Nombre', 'Teléfono | Correo', 'Info Adicional', '#Pagos Recibidos', 'Acciones'];

    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" theme="light" with-buttons striped hoverable>


        @foreach ($suppliers as $supplier)
            @if ($supplier->id != 1)
                <tr>
                    <td>
                        <img src="/images/supplier-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        {{ $supplier->name }}
                    </td>
                    <td>{{ $supplier->phone }} | <small>{{ $supplier->email }}</small> </td>

                    <td>{{ Str::limit($supplier->comment, 25) }}</td>
                    <td>{{ count($supplier->expenses) }}</td>

                    <div>
                        <td>

                            <a href="/suppliers/{{ $supplier->id }}/" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>
                            <a href="/indexsuppliers/{{ $supplier->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button> </a>

                            <form style="display:inline;" method="POST" action="/delsupplier/{{ $supplier->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="return confirm('¿Estas seguro de querer borrar el registro <<{{ $supplier->name }}>> ? \n ALERTA Si confirma no se podrá recuperar la información.')">
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
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
