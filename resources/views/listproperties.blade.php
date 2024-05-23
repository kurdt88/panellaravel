@extends('adminlte::page')

@section('title', 'Lista de Unidades')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Unidades
        @can('create')
            <a href="/newproperty" class="btn btn-tool btn-sm">
                [Nueva Unidad] <button class="btn btn-link"><i class="fas fa-plus"></i></button>
            </a>
        @endcan

    </h1>

@stop




@section('content')


    @php
        $heads = [
            'Titulo',
            'Propietario',
            'Renta Sugerida',
            'Último Contrato',

            'Unidad Habitacional',
            // ['label' => 'Phone', 'width' => 40],
            // ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            '# Subunidades',
            'Acciones',
        ];

        $config = [
            'order' => [[5, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($properties as $property)
            {{-- Se filtra en la vista a la propiedad 1     --}}
            @if ($property->id != 1)
                <tr>
                    <td>
                        <img src="/images/property-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        {{ $property->title }}
                    </td>
                    <td>

                        {{ App\Models\Landlord::whereId($property->landlord_id)->first()->name }}
                    </td>
                    <td>{{ Number::currency($property->rent) }}</td>

                    <td>
                        @php
                            $lastLease = App\Models\Lease::where('property', $property->id)
                                ->where('subproperty_id', 1)
                                ->get()
                                ->last();
                        @endphp
                        @if ($lastLease)
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
                                    <font color="#2B1B17">Por Vencer</font>
                                @elseif ($lastLease->isvalid == 1)
                                    <font color="#12AD2B">Vigente</font>
                                @endif
                            </b>
                        @else
                            <font color="#888B90"><b>Sin Contrato</b></font>
                        @endif
                    </td>

                    <td>
                        @if ($property->building_id == 1)
                            <font color="gray">Sin Unidad Habitacional</font>
                        @else
                            <a href="/buildings/{{ $property->building_id }}" class="text-muted">
                                {{ $property->building->name }}</a>
                        @endif
                    </td>

                    <td>
                        {{ count($property->subproperties) }}
                    </td>
                    <div>
                        <td>
                            <a href="/properties/{{ $property->id }}/" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>
                            @can('edit')
                                <a href="/indexproperties/{{ $property->id }}/edit" class="text-muted">
                                    <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </button> </a>
                            @endcan

                            @can('delete')
                                <form style="display:inline;" method="POST" action="/delproperty/{{ $property->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
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
