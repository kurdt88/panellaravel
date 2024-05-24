@extends('adminlte::page')



@section('title', 'Lista de Recibos')


@section('content_header')
    <x-flash-message />

    <h1>Lista de Recibos
        @can('create')
            <a href="/newinvoice" class="btn btn-tool btn-sm">
                [Nuevo Recibo] <button class="btn btn-link"><i class="fas fa-plus"></i></button>
            </a>
        @endcan
    </h1>

@stop




@section('content')




    @php
        $heads = ['Tipo', 'Propiedad', 'Concepto', 'Divisa/Monto', 'Inicia/Vence', 'Estado', 'Acciones'];
        $config = [
            'order' => [[5, 'desc']],
        ];

    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($invoices as $invoice)
            <tr>
                <td>
                    @if ($invoice->category == 'Ingreso')
                        <img src="/images/add-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    @endif
                    @if ($invoice->category == 'Egreso')
                        <img src="/images/less-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    @endif

                    {{ $invoice->category }}

                    </a>

                </td>


                <td>
                    @if ($invoice->lease_id != 1)
                        @if ($invoice->lease->subproperty_id != 1)
                            {{ Str::limit($invoice->lease->subpropertyname, 25) }}
                        @else
                            {{ $invoice->lease->property_->title }}
                        @endif
                    @else
                        @if ($invoice->subproperty_id)
                            {{ App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->type }} |
                            {{ Str::limit(App\Models\Subproperty::whereId($invoice->subproperty_id)->first()->title, 20) }}
                        @else
                            {{ App\Models\Property::whereId($invoice->property_id)->first()->title }}
                        @endif
                    @endif

                </td>
                <td>
                    {{ Str::limit($invoice->concept, 20) }} | {{ Str::limit($invoice->subconcept, 20) }} |
                    <small>{{ Str::limit($invoice->comment, 30) }}</small>


                </td>


                <td>
                    <small>{{ $invoice->type }}</small> {{ Number::currency($invoice->total) }}
                </td>
                <td>
                    {{ $invoice->start_date }} |
                    {{ $invoice->due_date }}
                </td>


                <td>
                    @if ($invoice->category == 'Ingreso')

                        @if ($invoice->ammount == 0)
                            <label style="color:rgb(90, 94, 96);">Excento Pago</label>
                        @elseif ($invoice->total - $invoice->payments->sum('ammount') == 0)
                            <label style="color:rgb(1, 109, 30);">Liquidado</label>
                        @else
                            @if ($invoice->lease->rescission)
                                <label style="color:rgba(143, 3, 3, 0.863);">Contrato Cancelado</label>
                            @else
                                @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->start_date)->isFuture())
                                    <label style="color:rgb(154, 155, 155);">Inactivo</label>
                                @else
                                    @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->due_date)->isPast())
                                        <label style="color:rgba(246, 2, 2, 0.7);">Vencido</label>
                                    @else
                                        <label style="color:rgb(198, 96, 0);">Por cobrar</label>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                    @if ($invoice->category == 'Egreso')
                        @if ($invoice->total - $invoice->expenses->sum('ammount') == 0)
                            <label style="color:rgb(1, 109, 30);">Liquidado</label>
                        @else
                            @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->start_date)->isFuture())
                                <label style="color:rgb(154, 155, 155);">Inactivo</label>
                            @else
                                @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->due_date)->isPast())
                                    <label style="color:rgba(246, 2, 2, 0.7);">Vencido</label>
                                @else
                                    <label style="color:rgb(47, 60, 194);">Por pagar</label>
                                @endif
                            @endif
                        @endif
                    @endif
                </td>


                <div>
                    <td>
                        <a href="/invoices/{{ $invoice->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>

                        @can('edit')
                            <a href="/indexinvoices/{{ $invoice->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button>
                            </a>
                        @endcan

                        @can('delete')
                            <form style="display:inline;" method="POST" action="/delinvoice/{{ $invoice->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="return confirm('¿Estas seguro de querer borrar el Recibo seleccionado ? \n ALERTA Si confirma no se podrá recuperar la información.')">

                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </td>
                </div>
            </tr>
        @endforeach


    </x-adminlte-datatable>





@stop

@section('css')
@stop
