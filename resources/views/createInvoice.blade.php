@extends('adminlte::page')


@section('title', 'Crear Recibo')

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
                <h3 class="card-title">Crear Recibo</h3>
            </div>


            <form method="POST" action="/indexinvoices" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label id="category_label">Tipo</label>
                        <select id="category" name="category" class="custom-select rounded-0">
                            <option value="">-- Selecciona una opción --</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Egreso">Egreso</option>

                        </select>

                        @error('category')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label id="concept_label">Categoría</label>
                        <select id="concept" name="concept" class="custom-select rounded-0">
                        </select>
                        @error('concept')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label id="subconcept_label">Concepto</label>
                        <select id="subconcept" name="subconcept" class="custom-select rounded-0">

                        </select>
                        @error('subconcept')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>




                    <label>Descripción</label>

                    <x-adminlte-textarea id="comment" name="comment" rows=1 label-class="text-dark" igroup-size="sm"
                        placeholder="Ingrese una breve descripción">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-light">
                                <i class="fas fa-edit "></i>
                            </div>
                        </x-slot>
                        {{ old('comment') }}
                    </x-adminlte-textarea>




                    <label id="lease-dropdown_label">Contrato asociado</label>
                    <div class="form-group">
                        <select id="lease-dropdown" name="lease_id" class="form-control">
                        </select>
                        @error('lease_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label id="property_type_label">Tipo de Propiedad a la que le asociará el Egreso </label>
                        <select name="property_type" id="property_type" class="custom-select rounded-0">

                        </select>
                        @error('property_type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label id="property_id_label">Unidad Asociada</label>

                        <select id="property_id" name="property_id" class="custom-select rounded-0">
                            <option value="">-- Selecciona una opción --</option>

                            @foreach (App\Models\Property::all() as $property)
                                @if ($property->id != 1)
                                    <option value="{{ $property->id }}">{{ $property->title }}</option>
                                @endif
                            @endforeach

                        </select>
                        @error('property_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label id="subproperty_id_label">Subunidad Asociada</label>

                        <select id="subproperty_id" name="subproperty_id" class="custom-select rounded-0">
                            <option value="">-- Selecciona una opción --</option>

                            @foreach (App\Models\Subproperty::all() as $subproperty)
                                @if ($subproperty->id != 1)
                                    <option value="{{ $subproperty->id }}">{{ $subproperty->type }} |
                                        {{ $subproperty->title }}</option>
                                @endif
                            @endforeach

                        </select>
                        @error('subproperty_id')
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
                        <label for="ammount">Monto</label>
                        <input type="number" min="1" step="any" class="form-control" name="ammount"
                            value="{{ old('ammount') }}">
                        @error('ammount')
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

                            {{-- <option value="IVA_ISR">IVA+ISR</option> --}}
                        </select>

                        @error('iva')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    @php
                        $config = [
                            'timePicker' => true,
                            'startDate' => 'js:moment()',
                            'endDate' => "js:moment().add(5,'days')",
                            'locale' => ['format' => 'YYYY-MM-DD'],
                        ];
                    @endphp
                    <font color="blue"><small>* El plazo por <i>default</i> para liquidar un Recibo es de <b>5 días</b>.
                            Si lo desea, puede modificar las fechas de inicio y vencimiento.</small></font>

                    <x-adminlte-date-range name="invoiceperiod" label="Fecha de Inicio y Vencimiento *" :config="$config">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-primary">
                                <i class="far fa-lg fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-date-range>




                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Recibo</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

        <script>
            $(document).ready(function() {
                /*------------------------------------------
                --------------------------------------------
                Country Dropdown Change Event
                --------------------------------------------
                --------------------------------------------*/



                $('#category').on('change', function() {
                    var category = $('#category').val();
                    $("#concept").html('');
                    $('#concept').html(
                        '<option value="">-- Selecciona una Opción --</option>"');

                    $("#subconcept").html('');
                    $('#subconcept').html(
                        '<option value="">-- Selecciona una Opción --</option>"');




                    if (category == 'Ingreso') {
                        // //Mostar Opciones Reducidas en el Campo concept
                        $("#concept").append(
                            '<option value="Ingreso General">Ingreso General</option>');



                        // $("#subconcept").append('<option value="RENTA DE LOCALES">RENTA DE LOCALES</option>');
                        // $("#subconcept").append(
                        //     '<option value="RENTA DE APARTAMENTOS">RENTA DE APARTAMENTOS </option>');
                        // $("#subconcept").append('<option value="DEPOSITOS">DEPOSITOS</option>');
                        // $("#subconcept").append(
                        //     '<option value="PAGO DE AGUA MENSUAL">PAGO DE AGUA MENSUAL</option>');
                        // $("#subconcept").append(
                        //     '<option value="PAGO DE CONEXION LUZ Y AGUA">PAGO DE CONEXION LUZ Y AGUA</option>'
                        // );
                        // $("#subconcept").append('<option value="MULTAS">MULTAS</option>');
                        // $("#subconcept").append('<option value="INTERESES">INTERESES</option>');
                        // $("#subconcept").append(
                        //     '<option value="RENTA DE ESTACIONAMIENTO">RENTA DE ESTACIONAMIENTO</option>');
                        // $("#subconcept").append(
                        //     '<option value="DEPOSITO POR MASCOTAS">DEPOSITO POR MASCOTAS</option>');
                        // $("#subconcept").append(
                        //     '<option value="ESTACIONAMIENTO POR HORA">ESTACIONAMIENTO POR HORA</option>');
                        // $("#subconcept").append(
                        //     '<option value="TARJETA EXTRA ESTACIONAMIENTO">TARJETA EXTRA ESTACIONAMIENTO</option>'
                        // );
                        // $("#subconcept").append('<option value="RENTA DE T.S. ">RENTA DE T.S. </option>');
                        // $("#subconcept").append('<option value="RENTA SAN JOSE">RENTA SAN JOSE</option>');
                        // $("#subconcept").append('<option value="RENTA">RENTA</option>');
                        // $("#subconcept").append(
                        //     '<option value="RENTA EXENTA POR PERIODO DE GRACIA">RENTA EXENTA POR PERIODO DE GRACIA</option>'
                        // );
                        // $("#subconcept").append('<option value="DEPOSITO CONTRATO">DEPOSITO CONTRATO</option>');
                        // $("#subconcept").append('<option value="OTRO">OTRO</option>');



                    } else {
                        //Mostar Opciones Reducidas en el Campo concept
                        $("#concept").append('<option value="Egreso_General">Egreso General</option>');
                        $("#concept").append(
                            '<option value="Compra de Inventario">Compra de Inventario</option>');


                        // $("#subconcept").append(
                        //     '<option value="DEVOLUCION DE DEPOSITO DE SEGURIDAD">DEVOLUCION DE DEPOSITO DE SEGURIDAD</option>'
                        // );

                        // $("#subconcept").append('<option value="PUBLICIDAD">PUBLICIDAD</option>');
                        // $("#subconcept").append(
                        //     '<option value="ESTUDIOS O LABORATORIOS">ESTUDIOS O LABORATORIOS</option>');

                        // $("#subconcept").append('<option value="COMPRA VENTA">COMPRA VENTA</option>');
                        // $("#subconcept").append('<option value="NOMINA IMSS">NOMINA IMSS</option>');
                        // $("#subconcept").append(
                        //     '<option value="POLIZA MANTENIMIENTO">POLIZA MANTENIMIENTO</option>');


                        // $("#subconcept").append(
                        //     '<option value="TARJETAS DE CREDITO">TARJETAS DE CREDITO</option>');
                        // $("#subconcept").append('<option value="POLIZAS DE SEGURO">POLIZAS DE SEGURO</option>');
                        // $("#subconcept").append('<option value="SERVICIO MEDICO">SERVICIO MEDICO</option>');

                        // $("#subconcept").append('<option value="VEHICULOS">VEHICULOS</option>');
                        // $("#subconcept").append(
                        //     '<option value="ALBERCAS MATERIAL Y MANTENIMIENTO">ALBERCAS MATERIAL Y MANTENIMIENTO</option>'
                        //     );


                        // $("#subconcept").append('<option value="OOMSAPAS">OOMSAPAS</option>');
                        // $("#subconcept").append('<option value="CFE">CFE</option>');
                        // $("#subconcept").append('<option value="TELMEX">TELMEX</option>');
                        // $("#subconcept").append('<option value="SUELDO PERSONAL">SUELDO PERSONAL</option>');
                        // $("#subconcept").append('<option value="AZTEK">AZTEK</option>');
                        // $("#subconcept").append('<option value="CAMARAS">CAMARAS</option>');
                        // $("#subconcept").append('<option value="CONTABILIDAD">CONTABILIDAD</option>');
                        // $("#subconcept").append('<option value="GASOLINA">GASOLINA</option>');
                        // $("#subconcept").append(
                        //     '<option value="ARTICULOS DE LIMPIEZA">ARTICULOS DE LIMPIEZA</option>');
                        // $("#subconcept").append(
                        //     '<option value="MATERIAL MANTENIMIENTO">MATERIAL MANTENIMIENTO</option>');
                        // $("#subconcept").append(
                        //     '<option value="MANTENIMIENTO ELEVADOR">MANTENIMIENTO ELEVADOR</option>');
                        // $("#subconcept").append('<option value="RECOLECTORA TAZ">RECOLECTORA TAZ</option>');
                        // $("#subconcept").append(
                        //     '<option value="DANIEL HIGUERA ANUAL">DANIEL HIGUERA ANUAL</option>');
                        // $("#subconcept").append('<option value="PREDIAL">PREDIAL</option>');
                        // $("#subconcept").append('<option value="COMISIONES">COMISIONES</option>');
                        // $("#subconcept").append('<option value="SAT">SAT</option>');
                        // $("#subconcept").append('<option value="IMSS">IMSS</option>');
                        // $("#subconcept").append('<option value="SAPAS LA PAZ">SAPAS LA PAZ</option>');
                        // $("#subconcept").append('<option value="TELCEL">TELCEL</option>');
                        // $("#subconcept").append('<option value="MUEBLES">MUEBLES</option>');
                        // $("#subconcept").append(
                        //     '<option value="REPARACION DE MUEBLES">REPARACION DE MUEBLES</option>');
                        // $("#subconcept").append(
                        //     '<option value="AIRES ACONDICIONADOS">AIRES ACONDICIONADOS</option>');
                        // $("#subconcept").append('<option value="CARPINTERIA">CARPINTERIA</option>');
                        // $("#subconcept").append('<option value="PINTURA">PINTURA</option>');
                        // $("#subconcept").append(
                        //     '<option value="SUELDO ADMINISTRACION">SUELDO ADMINISTRACION</option>');
                        // $("#subconcept").append('<option value="JARDINERIA">JARDINERIA</option>');
                        // $("#subconcept").append(
                        //     '<option value="RECOLECCION DE BASURA">RECOLECCION DE BASURA</option>');
                        // $("#subconcept").append(
                        //     '<option value="PERSONAL DE LIMPIEZA">PERSONAL DE LIMPIEZA</option>');
                        // $("#subconcept").append('<option value="COLEGIATURA">COLEGIATURA</option>');
                        // $("#subconcept").append(
                        //     '<option value="MENSUALIDAD ISABELLA">MENSUALIDAD ISABELLA</option>');
                        // $("#subconcept").append(
                        //     '<option value="OTRO"</option>');
                        // $("#subconcept").append(
                        //     '<option value=OTRO</option>');

                    }
                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            category: category,
                            concept: 'concepts',
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#subconcept').html(
                                '<option value="">-- Selecciona un Concepto --</option>');
                            $.each(result.concepts, function(key, value) {
                                $("#subconcept").append(
                                    '<option value="' + value
                                    .name +
                                    '">' + value.name +
                                    '</option>');
                            });

                        }
                    });


                    //Ahora oculto los campos NO necesarios para trabajar
                    $("#property_id").hide();
                    $("#property_id_label").hide();
                    $("#subproperty_id").hide();
                    $("#subproperty_id_label").hide();
                    $("#property_type").hide();
                    $("#property_type_label").hide();


                });


                $('#concept').on('change', function() {
                    var idCategory = $('#concept').val();

                    //Se trabaja con las Opciones de Contrato
                    $("#lease-dropdown").html('');
                    $("#property_type").html('');

                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            category: idCategory,
                            concept: 'leases',
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#lease-dropdown').html(
                                '<option value="">-- Selecciona un Contrato --</option>');
                            $.each(result.leases, function(key, value) {
                                if (value.id != 1) {
                                    if (value.isvalid == 1 || value.isvalid == 4 || value
                                        .isvalid == 5) {
                                        $("#lease-dropdown").append(
                                            '<option value="' + value
                                            .id +
                                            '">' + 'Propiedad: ' + value.propertyname +
                                            '  /  ' + value.subpropertyname +
                                            '  /  Propietario: ' + value.propertyowner +
                                            '  /  Arrendatario: ' + value.tenantname +
                                            '  /  Inicio: ' + value.start +
                                            '  /  Fin: ' + value.end +
                                            '  /  Renta: ' + value.rent +
                                            '  /  Divisa: ' + value.type +
                                            '  /  ' + value.iva +
                                            '  /  Info: ' + value.contract +
                                            '</option>');
                                    }
                                } else {

                                    $("#lease-dropdown").append(
                                        '<option value="' + value.id +
                                        '">' + 'Sin Contrato Asociado' +
                                        '</option>');
                                }
                            });

                        }
                    });





                });


                $('#lease-dropdown').on('change', function() {
                    var idLease = $('#lease-dropdown').val();
                    var idConcept = $('#concept').val();

                    // Sin un contrato Asociado. En este caso se debe mostrar el nuevo campo
                    // en donde se pregunta el tipo de propiedad a Asociar
                    if (idLease == 1) {
                        $("#property_type").show();
                        $("#property_type_label").show();

                        $("#property_type").html('');
                        $('#property_type').html('<option value="">-- Selecciona una Opcion --</option>"');

                        if (idConcept == "Egreso_General") {
                            $("#property_type").append('<option value="Unidad">Unidad</option>');
                            $("#property_type").append('<option value="Subunidad">Subunidad</option>');
                        } else {
                            $("#property_type").append('<option value="Unidad">Unidad</option>');
                        }

                    } else {
                        //Si hay un contrato Asociado se debe ocultar el campo
                        $("#property_type").hide();
                        $("#property_type_label").hide();
                    }
                });







                $('#property_type').on('change', function() {
                    var propType = $('#property_type').val();

                    if (propType == 'Unidad') {
                        $("#property_id").show();
                        $("#property_id_label").show();
                        $("#subproperty_id").hide();
                        $("#subproperty_id_label").hide();
                    } else if (propType == 'Subunidad') {
                        $("#property_id").hide();
                        $("#property_id_label").hide();
                        $("#subproperty_id").show();
                        $("#subproperty_id_label").show();
                    }



                });



            });
        </script>
    @stop
