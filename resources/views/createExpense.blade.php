@extends('adminlte::page')

@section('title', 'Crea Egreso')

@section('content_header')
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')

@section('plugins.BsCustomFileInput', true)

<header class="text-center">

</header>



<div class="col-md-12">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar Egreso (Gasto)</h3>
        </div>


        <form method="POST" action="/indexexpenses" enctype="multipart/form-data">
            @csrf
            <div class="card-body">



                <div class="form-group">
                    <label>Fecha del Egreso</label>

                    <div>
                        <input type="date" name="date" onkeydown="return false" style="color:gray"
                            value="{{ Illuminate\Support\Carbon::now()->format('Y-m-d') }}" />

                    </div>
                    </label>
                    @error('date')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lease_id">Contrato asociado</label>
                    <select id="lease_id" name="lease_id" class="custom-select rounded-0">
                        <option value=0>-- Selecciona el Contrato --</option>

                        @foreach ($leases as $lease)
                            @if ($lease->leasependentexpenses == 1)
                                @if ($lease->id != 1)
                                    <option value="{{ $lease->id }}">
                                        Propiedad:
                                        <?php $myProperty = App\Models\Property::whereId($lease->property)->first(); ?>
                                        <?php $myPropertyId = App\Models\Property::whereId($lease->property)->first()->id; ?>

                                        {{ $myProperty->title }}&nbsp;|&nbsp;{{ $lease->subpropertyname }} &nbsp;|&nbsp;
                                        Propietario:

                                        @if ($lease->subproperty_id != 1)
                                            {{ App\Models\Landlord::whereId($lease->subproperty->landlord_id)->first()->name }}&nbsp;|&nbsp;
                                        @else
                                            {{ App\Models\Landlord::whereId($lease->property_->landlord_id)->first()->name }}
                                        @endif

                                        | Arrendatario:
                                        {{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}&nbsp;|&nbsp;
                                        Inicio: {{ $lease->start }}&nbsp;Fin:{{ $lease->end }}&nbsp;|&nbsp;
                                        Divisa: {{ $lease->type }}&nbsp;|&nbsp;&nbsp;
                                        Renta: {{ Number::currency($lease->rent) }}&nbsp;|&nbsp;&nbsp;
                                        Info Adicional:
                                        {{ Str::limit($lease->contract, 25) }}&nbsp;|&nbsp;&nbsp;

                                        @if ($lease->isvalid == 4)
                                            Estado: Por Iniciar
                                        @elseif ($lease->isvalid == 2)
                                            Estado: Cancelado
                                        @elseif ($lease->isvalid == 3)
                                            Estado: Vencido
                                        @elseif ($lease->isvalid == 1)
                                            Estado: Vigente
                                        @endif
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

                {{-- <div class="form-group">
                    <label id="building_id_label">Unidad Habitacional asociada</label>
                    <textarea type="text" class="custom-select rounded-0" id="building_id" disabled></textarea>

                </div>
                <div class="form-group">
                    <label id="building_budget_label">Presupuesto de Mantenimiento de la Unidad Habitacional
                        asociada</label>
                    <textarea type="text" class="custom-select rounded-0" id="building_budget" disabled></textarea>

                </div> --}}


                <label>Recibo asociado</label>

                <div class="form-group">
                    <select id="invoice-dropdown" name="invoice_id" class="form-control">
                    </select>
                    @error('invoice_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>



                <div class="form-group">
                    <label id="property_id_label">Propiedad asociada</label>
                    <textarea type="text" class="custom-select rounded-0" id="property_id" disabled></textarea>

                </div>


                <label for="paid">Pagado</label>

                <div class="form-group">
                    <textarea disabled type="text" id="paid" name="paid" class="custom-select rounded-0"></textarea>


                    @error('paid')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
                <label for="tobepaid">Por pagar</label>

                <div class="form-group">
                    <textarea disabled type="text" id="tobepaid" name="tobepaid" class="custom-select rounded-0"></textarea>


                    @error('tobepaid')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Divisa</label>
                    <select name="type" id="type" class="custom-select rounded-0">
                        <option value=''>-- Selecciona una Opción --</option>

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
                    <label style="color:rgb(0, 70, 100);" id="maintenance_budget_label">¿Afecta Presupuesto de
                        Mantenimiento?</label>
                    <select name="maintenance_budget" id="maintenance_budget" class="custom-select rounded-0">
                        <option value=''>-- Selecciona una Opción --</option>

                        <option value="Si">Si</option>
                        <option value="No">No</option>
                        <option selected="selected">
                            {{ old('maintenance_budget') }}
                        </option>
                    </select>
                    @error('maintenance_budget')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea disabled type="text" id="maintenance_budget_build" name="maintenance_budget_build"
                        class="custom-select rounded-0"></textarea>
                </div>


                <label id="rate_exchange_label">Tipo de cambio (Pesos por Dolar)</label>
                <input type="number" step="any" class="custom-select" name="rate_exchange" id="rate_exchange"
                    placeholder="Ingrese el tipo de cambio (Pesos por Dolar)"></input>


                <label for="ammount">Monto</label>

                <div class="form-group">
                    <input type="number" step="any" id="ammount" name="ammount"
                        class="custom-select rounded-0"></input>
                    @error('ammount')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>


                <label>Cuenta Bancaria de donde se tomará el recurso</label>


                <div class="form-group">
                    <select id="account-dropdown" name="account_id" class="form-control">
                    </select>
                    @error('account_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>


                <label>Proveedor del servicio</label>

                <div class="form-group">
                    <select id="supplier-dropdown" name="supplier_id" class="form-control">
                    </select>
                    @error('supplier_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="supplier_id">Proveedor del servicio</label>
                    <select id="supplier_id" name="supplier_id" class="custom-select rounded-0">
                        <option value="">-- Selecciona un Proveedor --</option>

                        @foreach (App\Models\Supplier::all() as $supplier)
                            <option value="{{ $supplier->id }}">
                                Nombre:
                                {{ $supplier->name }}/
                                Comentario:
                                {{ $supplier->comment }}
                            </option>
                        @endforeach

                        <option selected="selected">
                            {{ old('supplier_id') }}
                        </option>
                    </select>

                    @error('supplier_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div> --}}

                <x-adminlte-textarea name="description" label="Información Adicional" rows=1 label-class="text-dark"
                    igroup-size="sm" placeholder="Información Adicional del gasto.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ old('description') }}
                </x-adminlte-textarea>


                {{-- With multiple slots and multiple files --}}
                <label>Seleccionar imágenes</label>

                <font color="blue"><small> * Máximo <b>2Mb</b> por archivo </small></font>
                <x-adminlte-input-file id="images" name="images[]" placeholder="Seleccionar imágenes..."
                    legend="Seleccionar imágenes" accept=".jpg, .png, .jpeg |image/* " value="{{ old('images[]') }}"
                    multiple>


                </x-adminlte-input-file>


                <label>Seleccionar archivos</label>

                <font color="blue"><small> * Máximo <b>2Mb</b> por archivo </small></font>
                <x-adminlte-input-file id="other_files" name="other_files[]" placeholder="Seleccionar archivos..."
                    legend="Seleccionar archivos" accept="application/pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx"
                    multiple>
                    {{ old('other_files') }}

                </x-adminlte-input-file>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar Egreso</button>

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
            $('#lease_id').on('change', function() {
                var idLease = this.value;


                $("#property_id").hide();
                $("#property_id_label").hide();
                $("#maintenance_budget").hide();
                $("#maintenance_budget_build").hide();
                $("#maintenance_budget_label").hide();
                $("#paid").html('');
                $("#tobepaid").html('');
                $("#invoice-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-invoices') }}",
                    type: "POST",
                    data: {
                        lease_id: idLease,
                        category: 'EgresoSimple',

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $("#rate_exchange").hide();
                        $("#rate_exchange_label").hide();

                        $('#invoice-dropdown').html(
                            '<option value="">-- Selecciona el Recibo --</option>');
                        $.each(result.invoices, function(key, value) {
                            $("#invoice-dropdown").append('<option value="' + value.id +
                                '">' + '[' + value.sequence + ']: ' +
                                value
                                .start_date + ' - ' +
                                value
                                .due_date + ' | Divisa: ' +
                                value
                                .type + ' | $' +
                                value.total2d + ' | ' +
                                value
                                .comment + ' | ' +
                                value
                                .concept + ' | ' +
                                value
                                .subconcept +
                                '</option>');
                        });
                    }
                });
            });



            $('#type').on('change', function() {
                var type = this.value;
                var idLease = $('#lease_id').val();
                var idInvoice = $('#invoice-dropdown').val();


                $.ajax({
                    url: "{{ url('api/fetch-invoices') }}",
                    type: "POST",
                    data: {
                        lease_id: idLease,
                        invoice_id: idInvoice,
                        type: type,
                        concept: 'accounts_expense',

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#account-dropdown').html(
                            '<option value=0>-- Selecciona la cuenta Bancaria --</option>'
                        );
                        $.each(result.accounts, function(key, value) {
                            $("#account-dropdown").append('<option value="' + value
                                .id +
                                '">' + '[' + value.type + ']: ' +
                                value.alias + ' - ' +
                                value.bank + ' - ' +
                                value.number + ' / Propietario: ' +
                                value.owner + '</option>');
                        });

                    }
                });

                var strtype = $('#type').val();

                $.ajax({
                    url: "{{ url('api/fetch-invoices') }}",
                    type: "POST",
                    data: {
                        invoice_id: idInvoice,
                        concept: 'type',
                        type: strtype,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {

                        if (result == 'notequal') {
                            $("#rate_exchange").show();
                            $("#rate_exchange_label").show();


                        } else {
                            $("#rate_exchange").hide();
                            $("#rate_exchange_label").hide();
                        }
                    }
                });

                $.ajax({

                    url: "{{ url('api/fetch-invoices') }}",
                    type: "POST",
                    data: {
                        lease_id: idLease,
                        invoice_id: idInvoice,
                        concept: 'propertyhasbuilding',
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(result) {

                        if (result == '--') {
                            $("#maintenance_budget").hide();
                            $("#maintenance_budget_label").hide();
                            $("#maintenance_budget_build").hide();

                        } else {
                            $("#maintenance_budget").show();
                            $("#maintenance_budget_label").show();

                            $("#maintenance_budget_build").show();
                            $("#maintenance_budget_build").html(result);
                        }
                    }
                });
            });

            // $('#type').on('change', function() {
            //     var idInvoice = $('#invoice-dropdown').val();
            //     var strtype = $('#type').val();


            //     $.ajax({
            //         url: "{{ url('api/fetch-invoices') }}",
            //         type: "POST",
            //         data: {
            //             invoice_id: idInvoice,
            //             concept: 'type',
            //             type: strtype,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         success: function(result) {

            //             if (result == 'notequal') {
            //                 $("#rate_exchange").show();
            //                 $("#rate_exchange_label").show();


            //             } else {
            //                 $("#rate_exchange").hide();
            //                 $("#rate_exchange_label").hide();


            //             }



            //         }
            //     });
            // });

            // 4to listener
            $('#invoice-dropdown').on('change', function() {
                var idInvoice = $('#invoice-dropdown').val();
                var idLease = $('#lease_id').val();

                $("#paid").html('');
                $("#tobepaid").html('');
                $("#type").get(0).selectedIndex = 0;



                if (idInvoice != 0) {
                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            invoice_id: idInvoice,
                            concept: 'paid-expense',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {

                            $("#paid").html(result);
                        }
                    });

                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            invoice_id: idInvoice,
                            concept: 'tobepaid-expense',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            $("#tobepaid").html(result);
                        }
                    });




                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            invoice_id: idInvoice,
                            concept: 'find_supplier',
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {

                            $('#supplier-dropdown').html(
                                '<option value=0>-- Selecciona un Proveedor --</option>'
                            );
                            $.each(result.suppliers, function(key, value) {
                                $("#supplier-dropdown").append('<option value="' +
                                    value
                                    .id +
                                    '">' + '[' + value.name + ']: ' +
                                    value.comment + '</option>');
                            });

                        }
                    });



                    if (idLease == 1) {
                        $.ajax({
                            url: "{{ url('api/fetch-invoices') }}",
                            type: "POST",
                            data: {
                                invoice_id: idInvoice,
                                concept: 'property-nolease',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(result) {
                                $("#property_id").html(result);
                                $("#property_id").show();
                                $("#property_id_label").show();
                            }
                        });
                    } else {
                        $("#property_id").hide();
                        $("#property_id_label").hide();
                    }
                }
            });

            // $('#invoice-dropdown').on('change', function() {
            //     var idInvoice = $('#invoice-dropdown').val();
            //     var strconcept = 'tobepaid-expense';
            //     $("#tobepaid").html('');

            //     if (idInvoice != 0) {

            //         $.ajax({
            //             url: "{{ url('api/fetch-invoices') }}",
            //             type: "POST",
            //             data: {
            //                 invoice_id: idInvoice,
            //                 concept: strconcept,
            //                 _token: '{{ csrf_token() }}'
            //             },
            //             success: function(result) {

            //                 $("#tobepaid").html(result);

            //             }
            //         });
            //     }
            // });


            // $('#invoice-dropdown').on('change', function() {
            //     var idInvoice = $('#invoice-dropdown').val();
            //     var idLease = $('#lease_id').val();
            //     if (idInvoice != 0) {


            //         if (idLease == 1) {
            //             var strconcept = 'property-nolease';

            //             $.ajax({
            //                 url: "{{ url('api/fetch-invoices') }}",
            //                 type: "POST",
            //                 data: {
            //                     invoice_id: idInvoice,
            //                     concept: strconcept,
            //                     _token: '{{ csrf_token() }}'
            //                 },
            //                 success: function(result) {

            //                     $("#property_id").html(result);
            //                     $("#property_id").show();
            //                     $("#property_id_label").show();

            //                 }
            //             });
            //         } else {
            //             $("#property_id").hide();
            //             $("#property_id_label").hide();
            //         }
            //     }


            // });






        });
    </script>
@stop
