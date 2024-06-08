@extends('adminlte::page')


@section('title', 'Renovación de Contrato')

@section('content_header')
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')



    <header class="text-center">

    </header>


    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Renovar Contrato</h3>
            </div>


            <form method="POST" action="/indexleases" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Propiedad</label>
                        @if ($lease->subproperty_id != 1)
                            <input type="text" id="subproperty" value="{{ $lease->subproperty->title }}"
                                class="form-control" disabled />
                            <input type="hidden" id="property" name="property" value="{{ $lease->property }}" />
                            <input type="hidden" id="subproperty_id" name="subproperty_id"
                                value="{{ $lease->subproperty_id }}" />
                        @else
                            <input type="text" value="{{ $lease->property_->title }}" class="form-control" disabled />
                            <input type="hidden" id="property" name="property" value="{{ $lease->property }}" />
                            <input type="hidden" id="subproperty_id" name="subproperty_id"
                                value="{{ $lease->subproperty_id }}" />
                        @endif

                        @error('property')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>




                    <div class="form-group">
                        <label for="tenant">Arrendatario (Nombre o Razón Social)</label>
                        <input type="text" value="{{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}"
                            class="form-control" disabled />
                        <input type="hidden" id="tenant" name="tenant" value="{{ $lease->tenant }}" />
                        @error('tenant')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label id="months_grace_period_label">Periodo de gracia (meses)</label><small> * Campo
                            Opcional</small>
                        <br>
                        <font color="blue"><small>Valor actual:

                                @if ($mygrace = $lease->months_grace_period)
                                    {{ $mygrace }}
                                @else
                                    0
                                @endif

                            </small></font>
                        <select name="months_grace_period" class="custom-select rounded-0">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                        @error('months_grace_period')
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
                            <option value="Exento">Exento</option>
                            <option value="IVA">IVA</option>
                            <option value="IVA_ISR">IVA+ISR</option>
                            <option selected="selected">
                                {{ $lease->iva }}
                            </option>
                        </select>

                        @error('iva')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Renta Mensual</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                {{ Number::currency($lease->rent) }} / * Se recomienda <b>revisar y ajustar</b>
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
                                {{ Number::currency($lease->deposit) }} / * Se recomienda <b>revisar y ajustar</b>
                            </small></font>
                        <input type="number" class="form-control" name="deposit" value="{{ $lease->deposit }}">
                        @error('deposit')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $config = [
                            'timePicker' => true,
                            'startDate' => Illuminate\Support\Carbon::createFromFormat('Y-m-d', $lease->end)->format(
                                'Y-m-d',
                            ),
                            'endDate' => Illuminate\Support\Carbon::createFromFormat('Y-m-d', $lease->end)
                                ->addYears(1)
                                ->format('Y-m-d'),
                            'locale' => ['format' => 'YYYY-MM-DD'],
                        ];
                    @endphp

                    <label>Fecha de Inicio y Fin*</label>
                    <br>
                    <font color="blue"><small>Valores contrato actual:
                            {{ $lease->start }} - {{ $lease->end }} <br> *El periodo por default para la renovación de
                            Contrato es de 12 meses. <b>Revisar y en su caso ajustar las fechas al periodo deseado. </b>
                        </small></font>
                    <x-adminlte-date-range name="leaseperiod" label="" :config="$config">
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
                        <textarea class="form-control" name="contract" rows="3">{{ $lease->contract }}</textarea>
                        @error('contract')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Renovar Contrato</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
        <script>
            $(document).ready(function() {
                /*------------------------------------------
                --------------------------------------------
                Country Dropdown Change Event
                --------------------------------------------
                --------------------------------------------*/
                $('#property').on('change', function() {
                    var idProperty = this.value;
                    console.log(idProperty);

                    $("#subproperty-dropdown").html('');
                    $.ajax({
                        url: "{{ url('api/fetch-subproperties') }}",
                        type: "POST",
                        data: {
                            property_id: idProperty,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#subproperty-dropdown').html(
                                '<option value="">-- Selecciona una Subunidad --</option>');
                            $.each(result.subproperties, function(key, value) {
                                if (value.id != 1) {

                                    $("#subproperty-dropdown").append(
                                        '<option value="' + value
                                        .id +
                                        '">' + '[' + value.type + ']: ' + '[' + value
                                        .title + ']: ' +
                                        value
                                        .address + '</option>');
                                }
                            });

                        }
                    });
                });




            });
        </script>


    @stop
