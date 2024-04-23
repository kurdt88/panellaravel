@extends('adminlte::page')

@section('title', 'Lista de Egresos')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Egresos<a href="/newexpense" class="btn btn-tool btn-sm">
            [Nuevo Egreso] <button class="btn btn-link"><i class="fas fa-plus"></i></button></a></h1>

@stop




@section('content')





    @php
        $heads = ['Fecha', 'Monto', 'Descripción', 'Propiedad | Contrato', 'Propietario', 'Recibo', 'Acciones'];
        $config = [
            'order' => [[0, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    {{-- <x-adminlte-datatable id="table2" :heads="$heads" theme="light" striped hoverable> --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($expenses as $expense)
            <tr>


                <td>
                    <img src="/images/expense-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    {{ $expense->date }}
                </td>

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
                    {{ Str::limit($expense->description, 25) }} | {{ Str::limit($expense->invoice->comment, 20) }}


                </td>


                @if ($expense->lease_id == 1)
                    <td>
                        {{-- <i> Sin contrato asociado </i> --}}
                        @if ($myprop_id = $expense->invoice->property_id)
                            {{ App\Models\Property::whereid($myprop_id)->first()->title }}
                        @endif
                        @if ($mysubprop_id = $expense->invoice->subproperty_id)
                            {{ App\Models\Subproperty::whereid($mysubprop_id)->first()->title }}
                        @endif
                        | <small>[Sin Contrato]</small>
                    </td>
                @else
                    <td>
                        @if (App\Models\Lease::whereId($expense->invoice->lease_id)->first()->subpropertyname != '--')
                            {{ Str::limit(App\Models\Lease::whereId($expense->invoice->lease_id)->first()->subpropertyname, 20) }}
                        @else
                            {{ App\Models\Lease::whereId($expense->invoice->lease_id)->first()->property_->title }}
                        @endif
                        |
                        <i class="far fa-file-alt"></i>
                        <a href="/leases/{{ App\Models\Lease::whereId($expense->lease->id)->first()->id }}/">
                            <small>[Ver]</small>
                        </a>

                    </td>
                @endif







                @if ($expense->lease_id == 1)
                    <td>

                        {{ $expense->account->landlord->name }}
                    </td>
                @else
                    <td>

                        @if ($expense->lease->subproperty_id != 1)
                            {{ App\Models\Landlord::whereId($expense->lease->subproperty->landlord_id)->first()->name }}
                        @else
                            {{ App\Models\Landlord::whereId($expense->lease->property_->landlord_id)->first()->name }}
                        @endif


                    </td>
                @endif


                <td>
                    <i class="far fa-file-alt"></i>
                    <a href="/invoices/{{ $expense->invoice->id }}/">
                        <small>[Ver]</small>
                    </a>

                </td>
                <td>







                    <a href="/expenses/{{ $expense->id }}/" class="text-muted">
                        <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </button>
                    </a>
                    <a href="/indexexpenses/{{ $expense->id }}/edit" class="text-muted">
                        <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button> </a>

                    <form style="display:inline;" method="POST" action="/delexpense/{{ $expense->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                            onclick="return confirm('¿Estas seguro de querer borrar el Gasto <<{{ $expense->title }}>> ? \n ALERTA Si confirma no se podrá recuperar la información.')">

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
@stop
