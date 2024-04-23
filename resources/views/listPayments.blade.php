@extends('adminlte::page')

@section('title', 'Lista de Ingresos')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Ingresos<a href="/newpayment" class="btn btn-tool btn-sm">
            [Nuevo Ingreso] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a></h1>

@stop




@section('content')





    @php
        $heads = ['Fecha', 'Monto', 'Concepto', 'Propiedad | Contrato', 'Arrendatario', 'Recibo', 'Acciones'];

        $config = [
            'order' => [[6, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    {{-- <x-adminlte-datatable id="table2" :heads="$heads" theme="light" striped hoverable> --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($payments as $payment)
            <tr>


                <td>
                    <img src="/images/payment-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    {{ $payment->date }}
                </td>
                <td>

                    @if (is_null($payment->rate_exchange))
                        <small>{{ $payment->type }}</small> {{ Number::currency($payment->ammount) }}
                    @else
                        <small>{{ $payment->type }}</small>
                        {{ Number::currency($payment->ammount_exchange) }}
                        <font color="gray">(<small>{{ $payment->invoice->type }}</small>
                            {{ Number::currency($payment->ammount) }})</font>
                    @endif


                </td>

                <td>
                    {{ Str::limit($payment->invoice->comment, 25) }}
                    | {{ Str::limit($payment->comment, 25) }}

                </td>

                @if ($payment->lease_id == 1)
                    <td>
                        {{-- <i> Sin contrato asociado </i> --}}
                        @if ($myprop_id = $payment->invoice->property_id)
                            {{ App\Models\Property::whereid($myprop_id)->first()->title }}
                        @endif
                        @if ($mysubprop_id = $payment->invoice->subproperty_id)
                            {{ App\Models\Subproperty::whereid($mysubprop_id)->first()->title }}
                        @endif
                        | <small>[Sin Contrato]</small>
                    </td>
                @else
                    <td>
                        @if (App\Models\Lease::whereId($payment->invoice->lease_id)->first()->subpropertyname != '--')
                            {{ Str::limit(App\Models\Lease::whereId($payment->invoice->lease_id)->first()->subpropertyname, 20) }}
                        @else
                            {{ App\Models\Lease::whereId($payment->invoice->lease_id)->first()->property_->title }}
                        @endif
                        <a href="/leases/{{ App\Models\Lease::whereId($payment->lease->id)->first()->id }}/">
                            | <small>[Ver Contrato]</small>
                        </a>

                    </td>
                @endif













                <td>
                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->name }}

                <td>
                    <i class="far fa-file-alt"> </i>
                    <a href="/invoices/{{ $payment->invoice->id }}/">
                        <small>[Ver]</small>
                    </a>

                </td>

                <div>
                    <td>
                        {{-- <a href="/pdf/{{ $payment->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-info mx-1 shadow" style="font-size:15px;"
                                title="PDF">
                                <i class="fa fa-file"></i>
                            </button>
                        </a> --}}
                        <a href="/payments/{{ $payment->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>
                        <a href="/indexpayments/{{ $payment->id }}/edit" class="text-muted">
                            <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </button> </a>

                        <form style="display:inline;" method="POST" action="/delpayment/{{ $payment->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </div>
            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
