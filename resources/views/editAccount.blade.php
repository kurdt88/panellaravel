@extends('adminlte::page')


@section('title', 'Editar Cuenta Bancaria')

@section('content_header')
    <x-flash-error-message />

@stop

@section('content')



    <header class="text-center">

    </header>

    <br>


    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editar Cuenta Bancaria</h3>
            </div>


            <x-adminlte-modal id="modalinfo1" title="Campos no 'Editables'" theme="primary">
                Las Cuentas Bancarias no pueden cambiar de "Propietario" ya que los movimientos registrados en una Cuenta
                Bancaria
                (Ingresos y Egresos) están asociados a las Propiedades y estos a sus Propietarios.
                <br><br>Del mismo modo, no es posible editar el campo "Divisa" ya que no se permite mezclar pagos en USD y
                en MXN dentro de una misma cuenta.
                <br><br>Si desea cambiar estos campos, Ud. debe: 1) Borrar todos los Ingresos y Egresos registrados dentro
                de
                esta Cuenta Bancaria, 2) Eliminar la Cuenta Bancaria y, 3) Crear una nueva Cuenta Bancaria.
            </x-adminlte-modal>

            <form method="POST" action="/indexaccounts/{{ $account->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="landlord_id">Propietario</label>
                        <font color="black"><small> * No se permite editar este campo.
                            </small></font>

                        <x-adminlte-button label="?" theme="warning" data-toggle="modal" data-target="#modalinfo1" />

                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ App\Models\Landlord::whereId($account->landlord_id)->first()->name }}</b>
                            </small></font>
                        <select name="landlord_id" class="custom-select rounded-0">
                            {{-- @foreach ($landlords as $landlord)
                                @if ($landlord->id != 1)
                                    @if ($landlord->id == $account->landlord_id)
                                        <option value="{{ $landlord->id }}" selected>{{ $landlord->name }}</option>
                                    @else
                                        <option value="{{ $landlord->id }}">{{ $landlord->name }}</option>
                                    @endif
                                @endif
                            @endforeach --}}

                            <option value="{{ $account->landlord_id }}" selected>

                                {{ App\Models\Landlord::whereId($account->landlord_id)->first()->name }}

                            </option>


                        </select>
                        @error('landlord_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alias</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $account->alias }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="alias" value="{{ $account->alias }}"
                            placeholder="Nombre corto para rápida identificación">
                        @error('alias')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="bank">Banco</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $account->bank }}</b>
                            </small></font>
                        <select name="bank" class="custom-select rounded-0">
                            <option value="Banco en Efectivo">Banco en Efectivo</option>
                            <option value="California Bank">California Bank</option>
                            <option value="ABC Capital">ABC Capital</option>
                            <option value="Accendo Banco">Accendo Banco</option>
                            <option value="American Express Bank">American Express Bank</option>
                            <option value="Autofin">Autofin</option>
                            <option value="Banco Actinver">Banco Actinver</option>
                            <option value="Banco Azteca">Banco Azteca</option>
                            <option value="Banco Bancrea">Banco Bancrea</option>
                            <option value="Banco Base">Banco Base</option>
                            <option value="Banco Bicentenario">Banco Bicentenario</option>
                            <option value="Banco Compartamos">Banco Compartamos</option>
                            <option value="Banco del Bajío">Banco del Bajío</option>
                            <option value="Banco Famsa">Banco Famsa</option>
                            <option value="Banco Forjadores">Banco Forjadores</option>
                            <option value="Banco Inbursa">Banco Inbursa</option>
                            <option value="Banco Interacciones">Banco Interacciones</option>
                            <option value="Banco Invex">Banco Invex</option>
                            <option value="Banco Multiva">Banco Multiva</option>
                            <option value="Banco PagaTodo">Banco PagaTodo</option>
                            <option value="Banco Progreso">Banco Progreso</option>
                            <option value="Banco Regional (Banregio)">Banco Regional (Banregio)</option>
                            <option value="Banco S3">Banco S3</option>
                            <option value="Banco Sabadell">Banco Sabadell</option>
                            <option value="Banco Santander">Banco Santander</option>
                            <option value="Banco Shinhan de México">Banco Shinhan de México</option>
                            <option value="Banco Ve por Más (BX+)">Banco Ve por Más (BX+)</option>
                            <option value="Bank of America">Bank of America</option>
                            <option value="Bankaool">Bankaool</option>
                            <option value="Banorte">Banorte</option>
                            <option value="Banregio">Banregio</option>
                            <option value="BBVA México (Bancomer)">BBVA México (Bancomer)</option>
                            <option value="BNP Paribas">BNP Paribas</option>
                            <option value="CIBanco">CIBanco</option>
                            <option value="Citibanamex">Citibanamex</option>
                            <option value="Consubanco">Consubanco</option>
                            <option value="Creditea">Creditea</option>
                            <option value="Deutsche Bank México">Deutsche Bank México</option>
                            <option value="HSBC México">HSBC México</option>
                            <option value="Intercam Banco">Intercam Banco</option>
                            <option value="InvestaBank">InvestaBank</option>
                            <option value="JP Morgan">JP Morgan</option>
                            <option value="Kondinero">Kondinero</option>
                            <option value="Monex">Monex</option>
                            <option value="Scotiabank">Scotiabank</option>
                            <option value="Volkswagen Bank">Volkswagen Bank</option>
                            <option selected="selected">
                                {{ $account->bank }}
                            </option>
                        </select>
                        @error('bank')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Divisa</label>

                        <font color="black"><small> * No se permite editar este campo.
                            </small></font>

                        <x-adminlte-button label="?" theme="warning" data-toggle="modal" data-target="#modalinfo1" />
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $account->type }}</b>
                            </small></font>
                        <select name="type" class="custom-select rounded-0">
                            <option selected value="{{ $account->type }}">{{ $account->type }}</option>
                            {{-- <option value="USD">USD</option>

                            <option selected="selected">
                                {{ $account->type }}
                            </option> --}}
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Número de cta</label>
                        <br>
                        <font color="blue"><small>Valor actual:
                                <b>{{ $account->number }}</b>
                            </small></font>
                        <input type="text" class="form-control" name="number" value="{{ $account->number }} ">
                        @error('number')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <label>Información de la Cuenta</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $account->comment }}</b>
                        </small></font>
                    <x-adminlte-textarea name="comment" rows=2 label-class="text-dark" igroup-size="sm"
                        placeholder="Información Adicional......">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ $account->comment }}
                    </x-adminlte-textarea>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Cuenta Bancaria</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

    @stop
