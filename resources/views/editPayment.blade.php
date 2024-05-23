@extends('adminlte::page')

@section('title', 'Editar Ingreso')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />
    {{-- @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i>{{ $errors->first() }}</h5>
    @endif --}}
@stop

@section('content')



    <header class="text-center">

    </header>

    <br>


    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editar Ingreso</h3>
            </div>

            <form method="POST" action="/indexpayments/{{ $payment->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">



                    <div class="form-group">
                        <label>Fecha del pago</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>
                                    {{ $payment->date }}
                                </b>
                            </small></font>
                        <div>
                            <input type="date" name="date" onkeydown="return false" style="color:gray"
                                value="{{ $payment->date }}" />

                        </div>
                        </label>
                        @error('date')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>





                    <div class="form-group">
                        <label for="lease_id">Contrato asociado</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>
                                    Propiedad:
                                    {{ App\Models\Property::whereId($payment->lease->property)->first()->title }}&nbsp;/&nbsp;
                                    Arrendatario:
                                    {{ App\Models\Tenant::whereId($payment->lease->tenant)->first()->name }}&nbsp;/&nbsp;
                                    Inicio: {{ $payment->lease->start }}&nbsp;Fin:{{ $payment->lease->end }}&nbsp;/&nbsp;
                                    Divisa: {{ $payment->lease->type }}&nbsp;/&nbsp;&nbsp;
                                    Info Adicional:
                                    {{ Str::limit($payment->lease->contract, 25) }}
                                </b>
                            </small></font>
                        <select id="lease_id" name="lease_id" class="custom-select rounded-0">

                            <option value="">-- Selecciona el Contrato --</option>

                            @foreach ($leases as $lease)
                                @if ($lease->id != 1)
                                    <option value="{{ $lease->id }}">
                                        Propiedad:
                                        {{ App\Models\Property::whereId($lease->property)->first()->title }}&nbsp;/&nbsp;
                                        Arrendatario:
                                        {{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}&nbsp;/&nbsp;
                                        Inicio: {{ $lease->start }}&nbsp;Fin:{{ $lease->end }}&nbsp;/&nbsp;
                                        Divisa: {{ $lease->type }}&nbsp;/&nbsp;&nbsp;
                                        Info Adicional:
                                        {{ Str::limit($lease->contract, 25) }}
                                    </option>
                                @else
                                    <option value="{{ $lease->id }}">
                                        Sin contrato asociado
                                    </option>
                                @endif
                            @endforeach


                        </select>

                        @error('lease_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>




                    <label>Recibo asociado</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>
                                [{{ $payment->invoice->sequence }}]: {{ $payment->invoice->start_date }} -
                                {{ $payment->invoice->due_date }} / Divisa: {{ $payment->invoice->type }} /
                                {{ $payment->invoice->total }} / {{ $payment->invoice->comment }}
                            </b>
                        </small></font>
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




                    <div class="form-group">
                        <label for="type">Divisa del ingreso</label><br>
                        <font color="blue"><small>Valor actual:
                                <b>
                                    {{ $payment->type }}
                                </b>
                            </small></font>

                        <select name="type" id="type" class="custom-select rounded-0">
                            <option value="">-- Selecciona la Divisa --</option>
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>


                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <label id="rate_exchange_label">Tipo de cambio (Pesos por Dolar)</label><br>
                    @if ($payment->rate_exchange)
                        <label id="current_val_rate_exchange_label">
                            <font color="blue"><small>Valor actual:
                                    <b>
                                        {{ $payment->rate_exchange }}
                                    </b>
                                </small></font>
                        </label>
                        <input type="number" step="0.01" class="custom-select" name="rate_exchange" id="rate_exchange"
                            value={{ $payment->rate_exchange }}></input>
                    @else
                        <input type="number" step="0.01" class="custom-select" name="rate_exchange" id="rate_exchange"
                            value=""></input>
                    @endif

                    <label for="ammount">Monto del ingreso</label><br>
                    <font color="blue"><small>Valor actual:
                            <b>
                                @if ($payment->rate_exchange)
                                    {{ Number::Currency($payment->ammount_exchange) }}
                                    @php
                                        $myammount = $payment->ammount_exchange;
                                    @endphp
                                @else
                                    {{ Number::Currency($payment->ammount) }}
                                    @php
                                        $myammount = $payment->ammount;
                                    @endphp
                                @endif
                            </b>
                        </small></font>
                    <div class="form-group">
                        <input type="number" step="0.01" id="ammount" name="ammount" class="custom-select rounded-0"
                            value={{ $myammount }}></input>


                        @error('ammount')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>





                    <label>Cuenta Bancaria Destino</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>
                                [{{ $payment->account->type }}]: {{ $payment->account->alias }} -
                                {{ $payment->account->bank }} / {{ $payment->account->number }} /
                                Propietario: {{ $payment->account->owner }}
                            </b>
                        </small></font>

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
                        {{ $payment->comment }}
                    </x-adminlte-textarea>
                    <font color="blue"><small>Valor actual:
                            <b>
                                {{ $payment->comment }}
                            </b>
                        </small></font>



                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Ingreso</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>


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
            $('#lease_id').on('change', function() {
                var idLease = this.value;
                // va strcategory = "Ingreso";
                // console.log(idLease);
                // console.log(strconcept);


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
                        $("#current_val_rate_exchange_label").hide();





                        $('#invoice-dropdown').html(
                            '<option value="">-- Selecciona el Recibo --</option>');
                        $.each(result.invoices, function(key, value) {
                            $("#invoice-dropdown").append('<option value="' + value.id +
                                '">' + '[' + value.sequence + ']: ' +
                                value
                                .start_date + ' - ' +
                                value
                                .due_date + ' / Divisa: ' +
                                value
                                .type + ' / $' +
                                value.total + ' / ' +
                                value
                                .comment + '</option>');
                        });
                        // $('#invoice-dropdown').html(
                        //     '<option value="">-- Select Invoice 2 --</option>');
                    }
                });
            });






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
                            $("#current_val_rate_exchange_label").show();


                        } else {
                            $("#rate_exchange").hide();
                            $("#rate_exchange_label").hide();
                            $("#current_val_rate_exchange_label").hide();


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
