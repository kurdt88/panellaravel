@extends('adminlte::page')

@section('title', 'Editar Egreso')

@section('content_header')
    <x-flash-error-message />
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i>{{ $errors->first() }}</h5>
    @endif
@stop

@section('content')

@section('plugins.BsCustomFileInput', true)

<header class="text-center">

</header>

<br>


<div class="col-md-12">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Egreso</h3>
        </div>


        <form method="POST" action="/indexexpenses/{{ $expense->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label>Fecha del Egreso</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            {{ $expense->date }}
                        </small></font>

                    <div>
                        <input type="date" name="date" onkeydown="return false" style="color:gray"
                            value="{{ $expense->date }}" />

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

                            Propiedad:
                            {{ App\Models\Property::whereId($expense->lease->property)->first()->title }}&nbsp;/&nbsp;
                            Propietario:
                            {{ App\Models\Landlord::whereId($expense->lease->property_->landlord_id)->first()->name }}&nbsp;/&nbsp;
                            Arrendatario:
                            {{ App\Models\Tenant::whereId($expense->lease->tenant)->first()->name }}&nbsp;/&nbsp;
                            Inicio: {{ $expense->lease->start }}&nbsp;Fin:{{ $expense->lease->end }}

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
                        [{{ $expense->invoice->sequence }}]: {{ $expense->invoice->start_date }} -
                        {{ $expense->invoice->due_date }} / Divisa: {{ $expense->invoice->type }} /
                        {{ $expense->invoice->total }} / {{ $expense->invoice->comment }}
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
                    <label for="type">Divisa del Egreso</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            {{ $expense->type }}
                        </small></font>
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
                @if ($expense->rate_exchange)
                    <label id="current_val_rate_exchange_label">
                        <font color="blue"><small>Valor actual:
                                {{ $expense->rate_exchange }}
                            </small></font>
                    </label>
                    <input type="number" step="0.01" class="custom-select" name="rate_exchange" id="rate_exchange"
                        value={{ $expense->rate_exchange }}></input>
                @else
                    <input type="number" step="0.01" class="custom-select" name="rate_exchange" id="rate_exchange"
                        value=""></input>
                @endif


                <label for="ammount">Monto</label>
                <br>
                <font color="blue"><small>Valor actual:
                        {{ $expense->ammount }}
                    </small></font>
                <div class="form-group">
                    <input type="number" step="0.01" id="ammount" name="ammount" class="custom-select rounded-0"
                        value={{ $expense->ammount }}></input>
                    @error('ammount')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>


                <label>Cuenta Bancaria de donde se tomará el recurso</label>
                <br>
                <font color="blue"><small>Valor actual:
                        [{{ $expense->account->type }}]: {{ $expense->account->alias }} -
                        {{ $expense->account->bank }} / Divisa: {{ $expense->account->number }} /
                        Propietario: {{ $expense->account->owner }}
                    </small></font>

                <div class="form-group">
                    <select id="account-dropdown" name="account_id" class="form-control">
                    </select>
                    @error('account_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="supplier_id">Proveedor del servicio</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            Nombre:
                            {{ App\Models\Supplier::whereId($expense->supplier_id)->first()->name }}
                            &nbsp;/&nbsp;
                            Comentario:
                            {{ App\Models\Supplier::whereId($expense->supplier_id)->first()->comment }}
                        </small></font>

                    <select id="supplier_id" name="supplier_id" class="custom-select rounded-0">
                        <option value="">-- Selecciona un Proveedor --</option>
                        @foreach (App\Models\Supplier::all() as $supplier)
                            @if ($supplier->id == $expense->supplier_id)
                                <option selected value="{{ $supplier->id }}">
                                    Nombre:
                                    {{ $supplier->name }}&nbsp;/&nbsp;
                                    Comentario:
                                    {{ $supplier->comment }}
                                </option>
                            @else
                                <option value="{{ $supplier->id }}">
                                    Nombre:
                                    {{ $supplier->name }}&nbsp;/&nbsp;
                                    Comentario:
                                    {{ $supplier->comment }}
                                </option>
                            @endif
                        @endforeach

                        {{-- <option selected="selected">
                            {{ old('supplier_id') }}
                        </option> --}}
                    </select>

                    @error('supplier_id')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <x-adminlte-textarea name="description" label="Información Adicional" rows=1 label-class="text-dark"
                    igroup-size="sm" placeholder="Información Adicional del gasto.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ $expense->description }}
                </x-adminlte-textarea>
                <font color="blue"><small>Valor actual:
                        {{ $expense->description }}
                    </small></font>


                <br><br>

                <label>
                    <font color="blue">Imágenes actuales:</font>
                </label>

                <div class="col-12 product-image-thumbs">

                    @foreach ($expense->expenseimgs as $expenseimg)
                        @if ($expenseimg->type == 'image')
                            <a href="{{ asset('storage/' . $expenseimg->image) }}">
                                <div class="product-image-thumb">
                                    <img alt="Evidencia" width="300" height="auto"
                                        src="{{ $expenseimg->image ? asset('storage/' . $expenseimg->image) : asset('/images/no-image.png') }}"
                                        alt="" />
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>


                <x-adminlte-input-file id="images" name="images[]" label="Seleccionar nuevas imágenes"
                    placeholder="Seleccionar archivos..." legend="Seleccionar archivos"
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple>
                </x-adminlte-input-file>

                <br><br>

                <label for="image">
                    <font color="blue">Archivos actuales:</font>
                </label>

                <div class="col-12 product-image-thumbs">
                    <ul>

                        @foreach ($expense->expenseimgs as $expenseimg)
                            @if ($expenseimg->type == 'file')
                                <a href="{{ asset('storage/' . $expenseimg->image) }}">
                                    <a href="{{ asset('storage/' . $expenseimg->image) }}">
                                        <li>{{ $expenseimg->original_name }}</li>
                                    </a>
                                </a>
                            @endif
                        @endforeach
                    </ul>

                </div>


                <x-adminlte-input-file id="other_files" name="other_files[]" label="Seleccionar otros archivos"
                    placeholder="Seleccionar archivos..." legend="Seleccionar archivos"
                    accept="application/pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx" multiple>

                </x-adminlte-input-file>


            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar Gasto</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





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

        // 4to listener
        $('#invoice-dropdown').on('change', function() {
            var idInvoice = $('#invoice-dropdown').val();
            var strconcept = 'paid-expense';

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
            var strconcept = 'tobepaid-expense';

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


    });
</script>
@stop
