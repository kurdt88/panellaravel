@extends('adminlte::page')

@section('title', 'Lista de Ingresos')


@section('content_header')
    <x-flash-message />


    <h1>Pagos hechos a favor del Proveedor</h1>
    <label style="color:rgb(2, 110, 94)">{{ $supplier->name }}</label>
@stop




@section('content')





    @php
        $heads = [
            'Recibo Asociado',
            'Concepto',
            'Propiedad',
            // 'Propietario',
            'Monto',
            'Resúmen de Pagos del Recibo Asociado',
            'Descripción',
            'Fecha',
            'Ver Mas',
        ];
        $config = [
            'order' => [[6, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    {{-- <x-adminlte-datatable id="table2" :heads="$heads" theme="light" striped hoverable> --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($supplier->expenses as $expense)
            <tr>


                <td>
                    <img src="/images/benefit-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    <a href="/invoices/{{ $expense->invoice_id }}/" class="text-muted">

                        {{ $expense->invoice->concept }}
                    </a>

                </td>
                <td>
                    {{ Str::limit($expense->invoice->comment, 20) }}

                </td>

                @if ($expense->lease_id == 1)
                    <td>
                        {{-- <i> Sin contrato asociado </i> --}}
                        @if ($myprop_id = $expense->invoice->property_id)
                            <a href="/properties/{{ $myprop_id }}/" class="text-muted">
                                {{ Str::limit(App\Models\Property::whereid($myprop_id)->first()->title, 20) }}
                            </a>
                        @endif
                        @if ($mysubprop_id = $expense->invoice->subproperty_id)
                            <a href="/subproperties/{{ $mysubprop_id }}/" class="text-muted">
                                {{ Str::limit(App\Models\Subproperty::whereid($mysubprop_id)->first()->title, 20) }}
                            </a>
                        @endif
                        {{-- | <small>&nbsp;[Sin Contrato Asociado]</small> --}}
                    </td>
                @else
                    <td>
                        {{-- <img src="/images/expense-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2"> --}}
                        <a href="/properties/{{ App\Models\Property::whereId($expense->lease->property)->first()->id }}/"
                            class="text-muted">
                            {{ Str::limit(App\Models\Property::whereId($expense->lease->property)->first()->title, 20) }}</a>

                        {{--
                         &nbsp;|
                       <a href="/leases/{{ App\Models\Lease::whereId($expense->lease->id)->first()->id }}/"
                            class="text-muted">
                            <i class='far fa-file-alt'> </i>
                            </i>
                        </a> --}}
                        </a>

                    </td>
                @endif



                {{-- @if ($expense->lease_id == 1)
                    <td>
                        <a href="/landlords/{{ $expense->account->landlord_id }}/" class="text-muted">

                            {{ $expense->account->landlord->name }}</a>
                    </td>
                @else
                    <td>

                        <a href="/landlords/{{ $expense->lease->property_->landlord_id }}/" class="text-muted">
                            {{ App\Models\Landlord::whereId($expense->lease->property_->landlord_id)->first()->name }}</a>
                    </td>
                @endif --}}




                <td>



                    @if (is_null($expense->rate_exchange))
                        <small>{{ $expense->type }}</small> {{ Number::currency($expense->ammount) }}
                    @else
                        <small>{{ $expense->type }}</small>
                        {{ Number::currency($expense->ammount_exchange) }}
                        <font color="gray">(<small>{{ $expense->invoice->type }}</small>
                            {{ Number::currency($expense->ammount) }})</font>
                    @endif



                </td>


                <td>
                    <label style="color:rgb(1, 109, 30)">Pagado: <small>{{ $expense->invoice->type }}</small>
                        {{ Number::currency($expense->invoice->expenses->sum('ammount')) }}
                    </label> |

                    <label style="color:rgb(103, 103, 103)">Por pagar: <small>{{ $expense->invoice->type }}</small>
                        {{ Number::currency($expense->invoice->total - $expense->invoice->expenses->sum('ammount')) }}
                    </label>
                </td>



                <td>
                    {{ Str::limit($expense->description, 25) }}
                </td>
                <td>
                    {{ $expense->date }}

                </td>
                <td>

                    <a href="/expenses/{{ $expense->id }}/" class="text-muted">
                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>
                    </a>

                </td>


            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
