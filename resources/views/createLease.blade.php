@extends('adminlte::page')


@section('title', 'Crear Contrato')

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
                <h3 class="card-title">Crear nuevo Contrato</h3>
            </div>


            <form method="POST" action="/indexleases" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="property">Propiedad</label>
                        <select name="property" class="custom-select rounded-0" id="property">
                            <option value="">-- Selecciona la Propiedad --</option>

                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->title }}</option>
                            @endforeach
                            {{-- <option selected="selected">
                                {{ old('property') }}
                            </option> --}}
                        </select>
                        @error('property')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>




                    <x-adminlte-button label="?" data-toggle="modal" data-target="#modalMin" theme="light" />
                    <label for="type">Subunidad </label>

                    <small> * Campo Opcional </small>
                    <x-adminlte-modal id="modalMin" title="Contrato de una Subunidad" theme="dark">
                        El sistema permite crear Contratos para Unidades (casas, departamentos, etc) y también para
                        Subunidades (lugares de estacionamiento, bodegas, etc).<br><br>
                        Si selecciona esta opción <b>se creará el contrato de una Subunidad</b> y no el de una Unidad.
                        <br><br>
                        Si lo que desea es crear un contrato de una Unidad, deje esta opción vacia.
                    </x-adminlte-modal>

                    {{-- Example button to open modal --}}



                    <div class="form-group">

                        <select id="subproperty-dropdown" name="subproperty_id" class="form-control">
                        </select>
                        @error('subproperty_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror



                    </div>



                    <div class="form-group">
                        <label for="tenant">Arrendatario (Nombre o Razón Social)</label>
                        <select name="tenant" class="custom-select rounded-0">
                            <option value="">-- Selecciona un Arrendatario --</option>

                            @foreach ($tenants as $tenant)
                                @if ($tenant->id != 1)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                @endif
                            @endforeach
                            {{-- <option selected="selected">
                                {{ old('tenant') }}
                            </option> --}}
                        </select>
                        @error('tenant')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label id="months_grace_period_label">Periodo de gracia (meses)</label><small> * Campo
                            Opcional</small>
                        <select name="months_grace_period" class="custom-select rounded-0">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>

                            <option selected="selected">
                                {{ old('months_grace_period') }}
                            </option>
                        </select>
                        @error('months_grace_period')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="type">Divisa</label>
                        <select name="type" class="custom-select rounded-0">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>

                            <option selected="selected">
                                {{ old('type') }}
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
                                {{ old('iva') }}
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
                        <label>Renta Mensual</label>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ old('rent') }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deposit">Depósito</label>
                        <input type="number" step="any" class="form-control" name="deposit"
                            value="{{ old('deposit') }}">
                        @error('deposit')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $config = [
                            // 'timePicker' => true,
                            'startDate' => 'js:moment()',
                            'endDate' => "js:moment().add(1,'years')",
                            'locale' => ['format' => 'YYYY-MM-DD'],
                        ];
                    @endphp
                    <x-adminlte-date-range name="leaseperiod" label="Fecha de Inicio y Fin" :config="$config">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="far fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>




                    <x-adminlte-textarea name="contract" label="Información Adicional" rows=1 label-class="text-dark"
                        igroup-size="sm" placeholder="Información Adicional......">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ old('contract') }}
                    </x-adminlte-textarea>


                </div>

                <x-adminlte-modal id="modalinfo1" title="Creación de Recibos de manera Automática" theme="primary">
                    Al crearse un nuevo contrato, el sistema crea de manera automática los Recibos correspondientes a las
                    Rentas (1 por mes) y al Depósito de Garatia (si hubiera). <br><br>Si desea revisar/editar/borrar estos
                    Recibos,
                    posterior a la creación del Contrato, vaya a la opción "Recibos".
                </x-adminlte-modal>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Contrato</button>
                    <x-adminlte-button label="Recibos (?)" theme="secondary" data-toggle="modal"
                        data-target="#modalinfo1" />


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
