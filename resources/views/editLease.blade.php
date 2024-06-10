@extends('adminlte::page')

@section('title', 'Modificar Contrato')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />

@stop

@section('content')



    <header class="text-center">

    </header>

    <x-adminlte-callout theme="danger" title-class="text-danger text-uppercase" icon="fas fa-handshake-slash"
        title="MODIFICAR UN CONTRATO PUEDE SER CAUSA DE SU INVALIDEZ">
        Previo a modificar cualquier información del Contrato se recomienda consultar al área Legal encargada.

    </x-adminlte-callout>



    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">

                <h3 class="card-title">Editar Contrato: {{ $lease->property_->title }}</h3>

            </div>


            <form method="POST" action="/indexleases/{{ $lease->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="property">Propiedad</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ $lease->property_->title }}
                            </small></font>
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
                        <label for="tenant">Arrendatario</i></label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ $lease->tenant_->name }}
                            </small></font>
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
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ $lease->type }}
                            </small></font>
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
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ $lease->iva }}
                            </small></font>
                        <select id="iva" name="iva" class="custom-select rounded-0">
                            <option selected="selected">
                                {{ $lease->iva }}
                            </option>
                            <option value="Exento">Exento</option>
                            <option value="IVA">IVA</option>
                            <option value="IVA_RETENCIONES">IVA+RETENCIONES</option>
                        </select>

                        @error('iva')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ Number::Currency($lease->rent) }}
                            </small></font>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ $lease->rent }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="deposit">Depósito</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ Number::Currency($lease->deposit) }}
                            </small></font>
                        <input type="number" step="any" class="form-control" name="deposit"
                            value="{{ $lease->deposit }}">
                        @error('deposit')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>






                    <x-adminlte-modal id="modalinfo1" title="Advertencia" theme="warning">
                        No se recomienda la modificación en las fechas
                        del
                        Contrato, ya que esto implica revisar y modificar de manera "manual" los Recibos asociados que se
                        generaron de manera automática al crearse el Contrato.
                        <br><br>Al crearse un nuevo contrato, el sistema crea de manera
                        automática los Recibos correspondientes a las
                        Rentas (1 por mes) y al Depósito de Garatia (si hubiera).
                        <br><br>
                        Si desea continuar con la modificación de las fechas del Contrato, también tome en cuenta que el
                        sistema
                        no generará nuevos Recibos (de renta o depósito) de manera automática ni tampoco actualizará los
                        anteriormente generados. Por lo que, estos cambios
                        deberán realizarse de manera manual.
                        <br><br>
                    </x-adminlte-modal>




                    @php
                        $config = [
                            'timePicker' => true,
                            'startDate' => $lease->start,
                            'endDate' => $lease->end,
                            'locale' => ['format' => 'YYYY-MM-DD'],
                        ];
                    @endphp
                    {{-- Label and placeholder --}}

                    <label>Fecha de Inicio y Vencimiento</label>
                    <x-adminlte-button label="?" theme="warning" data-toggle="modal" data-target="#modalinfo1" />
                    <br>
                    <font color="blue"><small>Valor actual:
                            {{ $lease->start }} - {{ $lease->end }}
                        </small></font>
                    <x-adminlte-date-range name="leaseperiod" :config="$config">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="far fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>


                    <div class="form-group">
                        <label for="contract">Información Adicional</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ $lease->contract }}
                            </small></font>
                        <textarea class="form-control" name="contract" rows="1">{{ $lease->contract }}</textarea>
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
