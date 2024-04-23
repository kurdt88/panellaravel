@extends('adminlte::page')

@section('title', 'Lista de Menaje')


@section('content_header')
    <x-flash-message />


    <h1>Menaje de la propiedad <strong>{{ $property->title }}</strong></h1>

@stop




@section('content')





    @php
        $heads = ['Concepto', 'Monto', 'Fecha', 'Ver Recibo'];

        $config = [
            'order' => [[1, 'desc']],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    {{-- <x-adminlte-datatable id="table2" :heads="$heads" theme="light" striped hoverable> --}}
    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($invoices as $invoice)
            <tr>
                <td>
                    <img src="/images/forniture-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">

                    {{ Str::limit($invoice->comment, 30) }}

                </td>
                <td>
                    <small>{{ $invoice->type }}</small> {{ Number::currency($invoice->ammount) }}
                </td>

                <td>
                    {{ $invoice->due_date }}
                </td>

                <div>
                    <td>
                        <a href="/invoices/{{ $invoice->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>

                    </td>
                </div>
            </tr>
        @endforeach


    </x-adminlte-datatable>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
