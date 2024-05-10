@extends('adminlte::page')

@section('title', 'Lista de Unidades Habitacionales')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Unidades Habitacionales<a href="/newbuilding" class="btn btn-tool btn-sm">
            [Nueva Unidad Habitacional] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a></h1>

@stop




@section('content')





    @php
        $heads = [
            'Nombre',
            'Dirección',
            'Descripción',
            // 'Presupuesto Mtto (MXN)',
            // 'Presupuesto Mtto (USD)',
            '# Propiedades',
            'Acciones',
        ];
        $config = [
            'order' => [[0, 'desc']],
        ];

    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($buildings as $building)
            {{-- Se filtra en la vista a la unidad habitacional 1     --}}
            @if ($building->id != 1)
                <tr>
                    <td>
                        <img src="/images/building-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        {{ $building->name }}

                    </td>

                    <td>
                        {{ Str::limit($building->address, 25) }}

                    </td>

                    <td>
                        {{ Str::limit($building->description, 25) }}

                    </td>

                    {{-- <td>
                        {{ Number::currency($building->maintenance_budget) }}
                    </td>
                    <td>
                        {{ Number::currency($building->maintenance_budget_usd) }}
                    </td> --}}
                    <td>
                        {{ count($building->properties) }}

                    </td>





                    <td>







                        <a href="/buildings/{{ $building->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>
                        <a href="/indexbuildings/{{ $building->id }}/edit" class="text-muted">
                            <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button> </a>

                        <form style="display:inline;" method="POST" action="/delbuilding/{{ $building->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                onclick="return confirm('¿Estas seguro de querer borrar la Unidad Habitacional <<{{ $building->name }}>> ? \n ALERTA Si confirma no se podrá recuperar la información.')">
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
