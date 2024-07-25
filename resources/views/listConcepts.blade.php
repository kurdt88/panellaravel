@extends('adminlte::page')

@section('title', 'Lista de Conceptos')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Conceptos
        @can('create')
            <a href="/newconcept" class="btn btn-tool btn-sm">
                [Nuevo Concepto] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a>
        @endcan
    </h1>

@stop




@section('content')





    @php
        $heads = ['Tipo', 'Concepto', 'Acciones'];
        $config = [
            'order' => [[2, 'desc']],
        ];

    @endphp

    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($concepts as $concept)
            <tr>
                <td>
                    <img src="/images/concept-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    {{ $concept->type }}

                </td>


                <td>
                    {{ $concept->name }}

                </td>





                <td>

                    @can('edit')
                        <a href="/indexconcepts/{{ $concept->id }}/edit" class="text-muted">
                            <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                        </a>
                    @endcan

                    @can('delete')
                        <form style="display:inline;" method="POST" action="/delconcept/{{ $concept->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                onclick="return confirm('¿Estas seguro de querer borrar el concepto <<{{ $concept->name }}>> ? \n ALERTA Si confirma no se podrá recuperar la información.')">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </form>
                    @endcan

                </td>
            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
@stop
