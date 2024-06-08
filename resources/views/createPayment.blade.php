@extends('adminlte::page')

@section('title', 'Registrar Ingreso')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')



    <header class="text-center">

    </header>



    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Ingreso (Pago)</h3>
            </div>


            <form method="POST" action="/indexpayments" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                    <div class="form-group">
                        <label>Fecha del pago</label>

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
                            <option value="">-- Selecciona el Contrato --</option>

                            @foreach ($leases as $lease)
                                @if ($lease->leasependentpayments == 1)
                                    @if ($lease->id != 1)
                                        <option value="{{ $lease->id }}">
                                            Propiedad:
                                            {{ App\Models\Property::whereId($lease->property)->first()->title }}&nbsp;|&nbsp;
                                            {{ $lease->subpropertyname }} &nbsp;|&nbsp;


                                            Propietario:

                                            @if ($lease->subproperty_id != 1)
                                                {{ $lease->subproperty->landlord->name }}&nbsp;|&nbsp;
                                            @else
                                                {{ $lease->property_->landlord->name }}
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

                            {{-- <option selected="selected">
                                {{ old('lease_id') }}
                            </option> --}}
                        </select>

                        @error('lease_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>




                    <label>Recibo asociado</label>

                    <div class="form-group">
                        <select id="invoice-dropdown" name="invoice_id" class="form-control">
                        </select>
                        @error('invoice_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
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


                    {{-- <div class="form-group">
                        <select id="invoice-dropdown" name="invoice_id" class="form-control">
                        </select>
                        @error('invoice_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="form-group">
                        <label for="type">Divisa del ingreso</label>
                        <select name="type" id="type" class="custom-select rounded-0">
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

                    <label id="rate_exchange_label">Tipo de cambio (Pesos por Dolar)</label>
                    <input type="number" step="any" class="custom-select" name="rate_exchange" id="rate_exchange"
                        placeholder="Ingrese el tipo de cambio (Pesos por Dolar)"></input>



                    <label for="ammount">Monto del ingreso</label>

                    <div class="form-group">
                        <input type="number" step="any" id="ammount" name="ammount"
                            class="custom-select rounded-0"></input>


                        @error('ammount')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>





                    <label>Cuenta Bancaria Destino</label>

                    <div class="form-group">
                        <select id="account-dropdown" name="account_id" class="form-control">
                        </select>
                        @error('account_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <x-adminlte-textarea name="comment" label="Información Adicional" rows=1 label-class="text-dark"
                        igroup-size="sm">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ old('comment') }}
                    </x-adminlte-textarea>




                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Registrar Ingreso</button>

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
                    // va strcategory = "Ingreso";
                    // console.log(idLease);
                    // console.log(strconcept);

                    $("#paid").html('');
                    $("#tobepaid").html('');
                    $("#invoice-dropdown").html('');
                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            lease_id: idLease,
                            category: 'IngresoSimple',

                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $("#rate_exchange").hide();
                            $("#rate_exchange_label").hide();




                            $('#invoice-dropdown').html(
                                '<option value="">-- Selecciona un Recibo --</option>');
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
                                    .subconcept + '</option>');
                            });
                            // $('#invoice-dropdown').html(
                            //     '<option value="">-- Select Invoice 2 --</option>');
                        }
                    });
                });




                // 3 er listener SI FUNCIONA
                // $('#invoice-dropdown').on('change', function() {
                //     var idInvoice = $('#invoice-dropdown').val();
                //     var strconcept = 'ammount';
                //     var idLease = $('#lease_id').val();



                //     $.ajax({
                //         url: "{{ url('api/fetch-invoices') }}",
                //         type: "POST",
                //         data: {
                //             invoice_id: idInvoice,
                //             lease_id: idLease,
                //             concept: strconcept,

                //             _token: '{{ csrf_token() }}'
                //         },
                //         success: function(result) {

                //             $.each(result.invoices, function(key, value) {
                //                 $("#ammount").html(value.ammount);
                //                 // $("#comment").html(value.ammount);

                //             });

                //         }
                //     });
                // });



                // 4to listener
                $('#invoice-dropdown').on('change', function() {
                    var idInvoice = $('#invoice-dropdown').val();
                    var strconcept = 'paid';

                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            invoice_id: idInvoice,
                            concept: strconcept,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {

                            $("#paid").html(result);


                        }
                    });
                });

                $('#invoice-dropdown').on('change', function() {
                    var idInvoice = $('#invoice-dropdown').val();
                    var strconcept = 'tobepaid';

                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            invoice_id: idInvoice,
                            concept: strconcept,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {

                            $("#tobepaid").html(result);
                            // $("#ammount").html(result);
                            // $("#rate_exchange").show();



                        }
                    });
                });

                $('#type').on('change', function() {
                    var idInvoice = $('#invoice-dropdown').val();
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
                });



                $('#type').on('change', function() {
                    var type = this.value;
                    var idLease = $('#lease_id').val();


                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            lease_id: idLease,
                            type: type,
                            concept: 'accounts',

                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {


                            $('#account-dropdown').html(
                                '<option value="">-- Selecciona la cuenta Bancaria --</option>');
                            $.each(result.accounts, function(key, value) {
                                $("#account-dropdown").append('<option value="' + value.id +
                                    '">' + '[' + value.type + ']: ' +
                                    value.alias + ' - ' +
                                    value.bank + ' - ' +
                                    value.number + ' / Propietario: ' +
                                    value.owner + '</option>');
                            });

                        }
                    });
                });



            });
        </script>
    @stop
