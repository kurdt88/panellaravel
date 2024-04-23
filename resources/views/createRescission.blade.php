@extends('adminlte::page')


@section('title', 'Resicion de Contrato')

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
                <h3 class="card-title">Cancelar Contrato: </h3>

            </div>


            <form method="POST" action="/cancellease" enctype="multipart/form-data">
                @csrf
                <div class="card-body">



                    <div class="form-group">
                        <label style="background-color:rgb(196, 243, 121)">
                            Propiedad:
                            {{ App\Models\Property::whereId($lease->property)->first()->title }}&nbsp;/&nbsp;
                            @if ($lease->subproperty_id != 1)
                                Subpropiedad:
                                [{{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->type }}]&nbsp;

                                {{ App\Models\Subproperty::whereId($lease->subproperty_id)->first()->title }}&nbsp;/&nbsp;
                            @endif


                            Propietario:
                            {{ App\Models\Landlord::whereId($lease->property_->landlord_id)->first()->name }}&nbsp;/&nbsp;
                            Arrendatario:
                            {{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}&nbsp;/&nbsp;
                            Renta:
                            <small>{{ $lease->type }}</small>$ {{ Number::currency($lease->rent) }}&nbsp;/&nbsp;
                            Inicio: {{ $lease->start }}&nbsp;Fin:{{ $lease->end }}
                        </label>

                    </div>

                    <input type="hidden" id="lease_id" name="lease_id" value={{ $lease->id }}>


                    <div class="form-group">
                        <label>Fecha de la cancelación</label>

                        <div>
                            <input type="date" name="date_start" onkeydown="return false" style="color:gray"
                                value="{{ Illuminate\Support\Carbon::now()->format('Y-m-d') }}" />

                        </div>
                        </label>
                        @error('date_start')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <x-adminlte-textarea name="reason" label="Motivo de la Cancelación" rows=1 label-class="text-dark"
                        igroup-size="sm" placeholder="Documente el motivo de la cancelación del contrato......">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ old('reason') }}
                    </x-adminlte-textarea>


                </div>
                <x-adminlte-card theme="danger" theme-mode="outline">
                    Al cancelarse el contrato se eliminirán del sistema los siguientes recibos, los cuales fueron emitidos
                    de manera automática por concepto de "Renta" y que a la fecha no tienen pagos asociados:
                    <br>
                    <div class="col-6">
                        <div>

                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Divisa/Monto</th>
                                        <th scope="col">Inicia/Vence</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->category }}</td>

                                            <td> {{ $invoice->concept }} <small>[{{ $invoice->sequence }}]</small>
                                            </td>

                                            <td>
                                                <small>{{ $invoice->type }}</small>
                                                {{ Number::currency($invoice->ammount) }}
                                            </td>

                                            <td>
                                                {{ $invoice->start_date }} |
                                                {{ $invoice->due_date }}
                                            </td>

                                            <td>
                                                @if ($invoice->ammount == 0)
                                                    <label style="color:rgb(90, 94, 96);">Excento Pago</label>
                                                @elseif ($invoice->total - $invoice->payments->sum('ammount') == 0)
                                                    <label style="color:rgb(1, 109, 30);">Liquidado</label>
                                                @else
                                                    @if ($invoice->lease->rescission)
                                                        <label style="color:rgba(246, 2, 2, 0.398);">Cancelado</label>
                                                    @else
                                                        @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->start_date)->isFuture())
                                                            <label style="color:rgb(154, 155, 155);">Inactivo</label>
                                                        @else
                                                            @if (Illuminate\Support\Carbon::createFromFormat('Y-m-d', $invoice->due_date)->isPast())
                                                                <label style="color:rgba(246, 2, 2, 0.398);">Vencido</label>
                                                            @else
                                                                <label style="color:rgb(198, 96, 0);">Por cobrar</label>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>


                </x-adminlte-card>

                <div class="card-footer">
                    {{-- <button type="submit" class="btn btn-primary">Cancelar Contrato</button> --}}
                    <x-adminlte-button class="btn-sm" type="submit" label="Cancelar Contrato" theme="outline-danger"
                        icon="fas fa-lg fa-trash" />

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
                                        '">' + '[' + value.title + ']: ' +
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
