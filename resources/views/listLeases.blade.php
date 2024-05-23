@extends('adminlte::page')



@section('title', 'Lista de Contratos')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Contratos
        @can('create')
            <a href="/newlease" class="btn btn-tool btn-sm">
                [Nuevo Contrato] <button class="btn btn-link"><i class="fas fa-plus"></i></button>
            </a>
        @endcan
    </h1>

@stop




@section('content')




    @php
        $heads = ['Propiedad | Subunidad', 'Propietario', 'Arrendador', 'Renta', 'Estado', 'Inicio/Fin', 'Acciones'];
        $config = [
            'order' => [[6, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($leases as $lease)
            @if ($lease->id != 1)
                <tr>
                    <td>


                        {{-- CASO 1 Contrato de una propiedad --}}
                        @if ($lease->property != 1 && $lease->subproperty_id == 1)
                            <img src="/images/lease-icon1.png" alt="Product 1" class="img-circle img-size-32 mr-2">

                            <a href="/properties/{{ $lease->property }}/" class="text-muted">
                                {{ $lease->property_->title }}
                            </a>
                        @endif
                        {{-- CASO 2 Contrato de una subpropiedad --}}
                        @if ($lease->subproperty_id != 1)
                            <img src="/images/lease-icon1.png" alt="Product 1" class="img-circle img-size-32 mr-2">

                            <a href="/subproperties/{{ $lease->subproperty_id }}/" class="text-muted">
                                {{ $lease->subproperty->type }} | {{ $lease->subproperty->title }}
                            </a>
                        @endif
                        {{-- CASO 2 Contrato de una subpropiedad --}}
                        {{-- @if ($lease->subproperty_id != 1)
                            <img src="/images/lease-icon1.png" alt="Product 1" class="img-circle img-size-32 mr-2">

                            <a href="/subproperties/{{ $lease->subproperty_id }}/" class="text-muted">
                                [{{ $lease->subproperty->type }}] {{ $lease->subproperty->title }}
                            </a>
                        @endif --}}

                    </td>
                    <td>
                        @if ($lease->subproperty_id != 1)
                            {{ App\Models\Landlord::whereId($lease->subproperty->landlord_id)->first()->name }}
                        @else
                            {{ App\Models\Landlord::whereId($lease->property_->landlord_id)->first()->name }}
                        @endif

                    </td>
                    <td>
                        {{ $lease->tenant_->name }}

                    </td>
                    <td>
                        <small>{{ $lease->type }}</small>$ {{ Number::currency($lease->rent) }}

                    </td>




                    <td>
                        <b>
                            @if ($lease->isvalid == 4)
                                <font color="#006A4E">Por Iniciar</font>
                            @elseif ($lease->isvalid == 2)
                                <font color="#413839">Cancelado</font>
                            @elseif ($lease->isvalid == 3)
                                <font color="#FF6700">Vencido</font>
                            @elseif ($lease->isvalid == 5)
                                <font color="#2B1B17">Por Vencer</font>
                            @elseif ($lease->isvalid == 1)
                                <font color="#12AD2B">Vigente</font>
                            @endif
                        </b>
                    <td>
                        {{ $lease->start }} / {{ $lease->end }}
                    </td>

                    <div>
                        <td>
                            <a href="/leases/{{ $lease->id }}/" class="text-muted">
                                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </button>
                            </a>

                            @can('edit')
                                <a href="/indexleases/{{ $lease->id }}/edit" class="text-muted">
                                    <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </button>
                                </a>
                            @endcan

                            @can('delete')
                                <form style="display:inline;" method="POST" action="/dellease/{{ $lease->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                        onclick="return confirm('¿Estas seguro de querer borrar el contrato? \n ALERTA Si confirma se borrarán todos los pagos asociados al contrato.')">

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
