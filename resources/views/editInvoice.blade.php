@extends('adminlte::page')


@section('title', 'Panel de Inicio')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />
    <x-flash-message />

@stop

@section('content')



    <header class="text-center">

    </header>

    <br>


    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editar Recibo # {{ $invoice->id }}</h3>
            </div>


            <form method="POST" action="/indexinvoices/{{ $invoice->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">


                    <div class="form-group">
                        <label for="category">Tipo</label>
                        <select id="category" name="category" class="custom-select rounded-0">
                            @if ($invoice->category == 'Ingreso')
                                <option value="Ingreso" selected>Ingreso</option>
                                <option value="Egreso">Egreso</option>
                            @else
                                <option value="Ingreso">Ingreso</option>
                                <option value="Egreso" selected>Egreso</option>
                            @endif
                            </option>


                        </select>

                        @error('category')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="concept">Concepto</label>
                        <input type="text" class="form-control" name="concept" value="{{ $invoice->concept }}"
                            placeholder="Ejemplo: Pago de Renta, Pago de Depósito, Gasto Proveedor, Gasto General">
                        @error('concept')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>




                    <div class="form-group">
                        <label for="lease_id">Contrato asociado</label>
                        <select id="lease_id" name="lease_id" class="custom-select rounded-0" id="exampleSelectRounded0">

                            <option value="">-- Selecciona el Contrato --</option>

                            @foreach ($leases as $lease)
                                @if ($lease->id != 1)
                                    @if ($invoice->lease_id == $lease->id)
                                        <option selected value="{{ $lease->id }}">
                                            Propiedad:
                                            {{ App\Models\Property::whereId($lease->property)->first()->title }}&nbsp;/&nbsp;
                                            Arrendatario:
                                            {{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}&nbsp;/&nbsp;
                                            Inicio: {{ $lease->start }}&nbsp;Fin:{{ $lease->end }}&nbsp;/&nbsp;
                                            Divisa: {{ $lease->type }}&nbsp;/&nbsp;&nbsp;
                                            Renta: {{ Number::currency($lease->rent) }}&nbsp;/&nbsp;&nbsp;

                                            {{ $lease->iva }}&nbsp;({{ $lease->iva_rate }} %)/&nbsp;&nbsp;
                                            Info Adicional:
                                            {{ Str::limit($lease->contract, 30) }}
                                        </option>
                                    @else
                                        <option value="{{ $lease->id }}">
                                            Propiedad:
                                            {{ App\Models\Property::whereId($lease->property)->first()->title }}&nbsp;/&nbsp;
                                            Arrendatario:
                                            {{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}&nbsp;/&nbsp;
                                            Inicio: {{ $lease->start }}&nbsp;Fin:{{ $lease->end }}&nbsp;/&nbsp;
                                            Divisa: {{ $lease->type }}&nbsp;/&nbsp;&nbsp;
                                            Renta: {{ Number::currency($lease->rent) }}&nbsp;/&nbsp;&nbsp;

                                            {{ $lease->iva }}&nbsp;({{ $lease->iva_rate }} %)/&nbsp;&nbsp;
                                            Info Adicional:
                                            {{ Str::limit($lease->contract, 30) }}
                                        </option>
                                    @endif
                                @else
                                    @if ($invoice->lease_id == $lease->id)
                                        <option selected value="{{ $lease->id }}">
                                            Sin contrato asociado
                                        </option>
                                    @else
                                        <option value="{{ $lease->id }}">
                                            Sin contrato asociado
                                        </option>
                                    @endif
                                @endif
                            @endforeach

                        </select>


                        @error('lease_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>






                    <div class="form-group">
                        <label for="type">Divisa</label>
                        <select name="type" class="custom-select rounded-0">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>

                            <option selected="selected">
                                {{ $invoice->type }}
                            </option>
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ammount">Monto</label>
                        <input type="number" min="1" step="any" class="form-control" name="ammount"
                            value="{{ $invoice->ammount }}">
                        @error('ammount')
                            <p class="text-red">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="iva">IVA</label>
                        <select id="iva" name="iva" class="custom-select rounded-0">
                            <option selected="selected">
                                {{ $invoice->iva }}
                            </option>
                            <option value="Exento">Exento</option>
                            <option value="IVA">IVA</option>
                            <option value="IVA_ISR">IVA+ISR</option>
                        </select>

                        @error('iva')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    @php
                        $config = [
                            'timePicker' => true,
                            'startDate' => $invoice->start_date,
                            'endDate' => $invoice->due_date,
                            'locale' => ['format' => 'YYYY-MM-DD'],
                        ];
                    @endphp
                    {{-- Label and placeholder --}}
                    <x-adminlte-date-range name="invoiceperiod" label="Fecha de Inicio y Vencimiento" :config="$config">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="far fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>

                    <x-adminlte-textarea name="comment" label="Información Adicional" rows=1 label-class="text-dark"
                        igroup-size="sm" placeholder="Información Adicional......">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ $invoice->comment }}
                    </x-adminlte-textarea>





                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Recibo</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

    @stop
