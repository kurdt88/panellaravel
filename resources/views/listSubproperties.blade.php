@extends('adminlte::page')

@section('title', 'Lista de Subunidades')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Subunidades
        @can('create')
            <a href="/newsubproperty" class="btn btn-tool btn-sm">
                [Nueva Subunidad] <button class="btn btn-link"><i class="fas fa-plus"></i></button>
            </a>
        @endcan
    </h1>

@stop




@section('content')


    @php
        $heads = [
            'Titulo',
            'Tipo',
            'Propietario',
            'Renta Sugerida',
            'Propiedad Asociada',
            'Último Contrato',
            'Acciones',
        ];
        $config = [
            'order' => [[6, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($subproperties as $subproperty)
            {{-- Se filtra en la vista a la propiedad 1     --}}
            @if ($subproperty->id != 1)
                <tr>
                    <td>
                        <img src="/images/subproperty-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        {{ Str::limit($subproperty->title, 25) }}
                    </td>
                    <td>
                        {{ $subproperty->type }}
                    </td>
                    <td>
                        <a href="/landlords/{{ $subproperty->landlord->id }}/" class="text-muted">
                            {{ App\Models\Landlord::whereId($subproperty->landlord_id)->first()->name }} </a>
                    </td>
                    <td>{{ Number::currency($subproperty->rent) }}</td>
                    <td>
                        @if ($subproperty->property->id == 1)
                            <font color="gray">{{ $subproperty->property->title }}</font>
                        @else
                            <a href="/properties/{{ $subproperty->property->id }}">
                                {{ $subproperty->property->title }}
                            </a>
                        @endif
                    </td>

                    <td>

                        @if ($lastLease = $subproperty->leases->last())
                            <a href="/leases/{{ $lastLease->id }}">
                                <i class='far fa-file-alt'> </i>
                                </i>
                            </a>
                            <b>
                                @if ($lastLease->isvalid == 4)
                                    <font color="#006A4E">Por Iniciar</font>
                                @elseif ($lastLease->isvalid == 2)
                                    <font color="#413839">Cancelado</font>
                                @elseif ($lastLease->isvalid == 3)
                                    <font color="#FF6700">Vencido</font>
                                @elseif ($lastLease->isvalid == 5)
                                    <font color="#2B1B17">En Renovación</font>
                                @elseif ($lastLease->isvalid == 1)
                                    <font color="#12AD2B">Vigente</font>
                                @endif
                            </b>
                        @else
                            <font color="#888B90"><b>Sin Contrato</b></font>
                        @endif
                    </td>


                    <div>
                        <td>
                            <a href="/subproperties/{{ $subproperty->id }}/" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>

                            @can('edit')
                                <a href="/indexsubproperties/{{ $subproperty->id }}/edit" class="text-muted">
                                    <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </button> </a>
                            @endcan

                            @can('delete')
                                <form style="display:inline;" method="POST" action="/delsubproperty/{{ $subproperty->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                        onclick="return confirm('¿Estás seguro de querer borrar la Subnidad Ingreso seleccionada ? \n ALERTA Si confirma no se podrá recuperar la información.')">

                                        <i class="fa fa-lg fa-fw fa-trash"></i>
                                    </button>
                                </form>
                            @endcan

                        </td>
                    </div>
                </tr>
            @endif
        @endforeach


    </x-adminlte-datatable>






@stop

@section('css')
@stop
