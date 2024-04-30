@extends('adminlte::page')

@section('title', 'Movimientos de la cuenta')


@section('content_header')
    <x-flash-message />




@stop




@section('content')

    <h4>Movimientos de la Cuenta<h6>
            <label style="color:rgb(2, 110, 94)">
                {{ $account->bank }} | {{ $account->alias }} | {{ $account->number }} | {{ $account->type }} |
                {{ $account->owner }}
            </label>
        </h6>
    </h4>
    @php
        $heads = ['Fecha', 'Monto', 'Propiedad', 'Concepto', 'Detalle', 'Info Adicional', 'Ver [+]'];
        $config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i>   >
                  <"row" <"col-12" tr> >
                  <"row" <"col-sm-12 d-flex justify-content-start" f> >';
        $config['paging'] = false;
        $config['lengthMenu'] = [100, 100, 100, 100];
    @endphp

    <x-adminlte-datatable id="table7" :heads="$heads" head-theme="secondary" theme="ligth" :config="$config" with-buttons
        striped compressed>

        <?php $moneyin = 0; ?>
        <?php $moneyout = 0; ?>


        @foreach ($payments as $payment)
            <tr>
                <td>
                    {{-- <img src="/images/up.png" alt="Product 1" class="img-circle img-size-32 mr-2"> --}}

                    {{ $payment->date }}
                </td>


                <td>


                    @if (is_null($payment->rate_exchange))
                        <font color="green">
                            (+)
                            {{-- <label style="color:rgb(1, 109, 30)"> <small>{{ $payment->type }}</small> --}}
                            <small>{{ $payment->type }}</small>

                            {{ Number::currency($payment->ammount) }}
                        </font>
                        <?php $moneyin += $payment->ammount; ?>
                    @else
                        (+)
                        <font color="green">
                            <small>{{ $payment->type }}</small>
                            {{ Number::currency($payment->ammount_exchange) }}
                        </font> /

                        <label style="color:rgb(103,
                            103, 103)"><small>{{ $payment->invoice->type }}
                                {{ Number::currency($payment->ammount) }}</small>
                        </label>
                        <?php $moneyin += $payment->ammount_exchange; ?>
                    @endif
                </td>

                <td>

                    @if ($payment->invoice->lease_id != 1)
                        @if ($payment->invoice->lease->subproperty_id != 1)
                            {{ $payment->invoice->lease->subpropertyname }}
                        @else
                            {{ $payment->invoice->lease->property_->title }}
                        @endif
                    @else
                        @if ($payment->invoice->subproperty_id)
                            {{ App\Models\Subproperty::whereId($payment->invoice->subproperty_id)->first()->type }}
                            |
                            {{ App\Models\Subproperty::whereId($payment->invoice->subproperty_id)->first()->title }}
                        @else
                            {{ App\Models\Property::whereId($payment->invoice->property_id)->first()->title }}
                        @endif
                    @endif


                </td>
                <td>{{ Str::limit($payment->invoice->concept, 20) }}</td>
                <td>{{ Str::limit($payment->invoice->comment, 20) }}</td>
                <td>{{ Str::limit($payment->comment, 20) }}</td>

                <div>
                    <td>

                        <a href="/payments/{{ $payment->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="far fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>
                    </td>
                </div>
            </tr>
        @endforeach


        @foreach ($expenses as $expense)
            <tr>
                <td>
                    {{-- <img src="/images/down.png" alt="Product 1" class="img-circle img-size-32 mr-2"> --}}

                    {{ $expense->created_at->toDateString() }}
                </td>


                <td>

                    @if (is_null($expense->rate_exchange))
                        (-)
                        <font color="black">

                            <small>{{ $expense->type }}</small>
                            {{ Number::currency($expense->ammount) }}
                        </font>

                        <?php $moneyout += $expense->ammount; ?>
                    @else
                        (-)
                        <font color="black">
                            <small>{{ $expense->type }}</small>
                            {{ Number::currency($expense->ammount_exchange) }}
                        </font>
                        /

                        <label style="color:rgb(103, 103, 103)"><small>{{ $expense->invoice->type }}
                                {{ Number::currency($expense->ammount) }}</small>
                        </label>
                        <?php $moneyout += $expense->ammount_exchange; ?>
                    @endif
                </td>

                <td>





                    {{-- @if ($expense->lease->property != 1)
                        <a href="/properties/{{ $expense->lease->property }}/" class="text-muted">
                            {{ App\Models\Property::whereId($expense->lease->property)->first()->title }}
                        </a>
                    @else
                        @if ($expense->invoice->property_id)
                            <a href="/properties/{{ $expense->invoice->property_id }}/" class="text-muted">
                                {{ App\Models\Property::whereId($expense->invoice->property_id)->first()->title }}
                            </a>
                        @endif
                        @if ($expense->invoice->subproperty_id)
                            <a href="/properties/{{ $expense->invoice->property_id }}/" class="text-muted">
                                Subunidad:
                                {{ App\Models\Subproperty::whereId($expense->invoice->subproperty_id)->first()->title }}
                            </a>
                        @endif
                    @endif --}}

                    @if ($expense->invoice->lease_id != 1)
                        @if ($expense->invoice->lease->subproperty_id != 1)
                            {{ $expense->invoice->lease->subpropertyname }}
                        @else
                            {{ $expense->invoice->lease->property_->title }}
                        @endif
                    @else
                        @if ($expense->invoice->subproperty_id)
                            {{ App\Models\Subproperty::whereId($expense->invoice->subproperty_id)->first()->type }}
                            |
                            {{ App\Models\Subproperty::whereId($expense->invoice->subproperty_id)->first()->title }}
                        @else
                            {{ App\Models\Property::whereId($expense->invoice->property_id)->first()->title }}
                        @endif
                    @endif


                </td>
                <td>{{ Str::limit($expense->invoice->concept, 20) }}</td>
                <td>{{ Str::limit($expense->invoice->comment, 20) }}</td>
                <td>{{ Str::limit($expense->description, 20) }}</td>
                <div>
                    <td>

                        <a href="/expenses/{{ $expense->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="far fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>
                    </td>
                </div>
            </tr>
        @endforeach



    </x-adminlte-datatable>

    <x-adminlte-card theme="lime" theme-mode="outline">
        Periodo | <label style="background-color:rgba(231, 244, 197, 0.829);">{{ $period }} </label><br>

        Total Ingresos:
        <font color="green">
            <small>{{ $account->type }}</small>
            {{ Number::currency($moneyin) }}
        </font><br>
        Total Egresos :
        <font color="black">
            <small>{{ $account->type }}</small>
            {{ Number::currency($moneyout) }}
        </font><br>
        Balance del Periodo:
        <label style="color:rgb(22, 100, 126)">
            <small>{{ $account->type }}</small>
            {{ Number::currency($moneyin - $moneyout) }}
        </label><br>



        <button onClick="window.print()" type="button" class="btn btn-warning float-right" style="margin-right: 5px;">
            <i class="fas fa-print"></i> Imprimir
        </button>
        <button onClick="location.href='/accountsearchmovements/{{ $account->id }}/'" type="button"
            class="btn btn-primary float-right" style="margin-right: 5px;">
            <i class="fas fa-coins"></i> Más movimientos
        </button>
        {{-- <button onClick="location.href='/accounts/'" type="button" class="btn btn-success float-right"
            style="margin-right: 5px;">
            <i class="fas fa-coins"></i> Todas las Cuentas
        </button> --}}
    </x-adminlte-card>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
