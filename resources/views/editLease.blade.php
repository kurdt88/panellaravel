@extends('adminlte::page')

@section('title', 'Panel de Inicio')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />

@stop

@section('content')



    <header class="text-center">

    </header>

    <br>
    <p>

    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i>Modificar un contrato puede causar su invalidez. Previo a
            modificarlo se recomienda verificarlo con el área Legal encargada.
        </h5>

    </div>
    </p>

    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                @foreach ($properties as $property)
                    @if ($property->id == $lease->property)
                        <h3 class="card-title">Editar Contrato: {{ $properties[$lease->property - 1]['title'] }}</h3>
                    @endif
                @endforeach
            </div>


            <form method="POST" action="/indexleases/{{ $lease->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="property">Propiedad <i>[{{ $properties[$lease->property - 1]['title'] }}]</i></label>
                        <select name="property" class="custom-select rounded-0" id="exampleSelectRounded0">

                            @foreach ($properties as $property)
                                @if ($property->id == $lease->property)
                                    <option value="{{ $property->id }}" selected>{{ $property->title }}</option>
                                @else
                                    <option value="{{ $property->id }}">{{ $property->title }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('property')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tenant">Arrendatario <i>[{{ $tenants[$lease->tenant - 1]['name'] }}]</i></label>
                        <select name="tenant" class="custom-select rounded-0" id="exampleSelectRounded0">
                            @foreach ($tenants as $tenant)
                                @if ($tenant->id == $lease->tenant)
                                    <option value="{{ $tenant->id }}" selected>{{ $tenant->name }}</option>
                                @else
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endif
                            @endforeach

                        </select>
                        @error('tenant')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Divisa</label>
                        <select name="type" class="custom-select rounded-0">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>

                            <option selected="selected">
                                {{ $lease->type }}
                            </option>
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="iva">IVA</label>
                        <select id="iva" name="iva" class="custom-select rounded-0">
                            <option selected="selected">
                                {{ $lease->iva }}
                            </option>
                            <option value="Exento">Exento</option>
                            <option value="IVA">IVA</option>
                            <option value="IVA_ISR">IVA_ISR</option>
                        </select>

                        @error('iva')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual</label>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ $lease->rent }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deposit">Depósito</label>
                        <input type="number" class="form-control" name="deposit" value="{{ $lease->deposit }}">
                        @error('deposit')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    @php
                        $config = [
                            'timePicker' => true,
                            'startDate' => $lease->start,
                            'endDate' => $lease->end,
                            'locale' => ['format' => 'YYYY-MM-DD'],
                        ];
                    @endphp
                    {{-- Label and placeholder --}}
                    <x-adminlte-date-range name="invoiceperiod" label="Fecha de Inicio y Vencimiento" :config="$config"
                        disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="far fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>

                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i>No se permite la modificación en las fechas del
                            contrato, toda vez que existen facturas asociadas al periodo inicialmente definido. En caso de
                            requerir su modificación consulte al administrador del sistema.
                        </h5>

                    </div>

                    <div class="form-group">
                        <label for="contract">Información Adicional</label>

                        <textarea class="form-control" name="contract" rows="3" placeholder="Información Adicional.">{{ $lease->contract }}</textarea>
                        @error('contract')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Contrato</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

    @stop
