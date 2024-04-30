@extends('adminlte::page')


@section('title', 'Crear Cuenta')

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
                <h3 class="card-title">Crear Cuenta Bancaria</h3>
            </div>


            <form method="POST" action="/indexaccounts" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="landlord_id">Propietario</label>
                        <select name="landlord_id" class="custom-select rounded-0">
                            <option value="">-- Selecciona al Propietario de la Cuenta --</option>

                            @foreach ($landlords as $landlord)
                                @if ($landlord->id != 1)
                                    <option value="{{ $landlord->id }}">{{ $landlord->name }}</option>
                                @endif
                            @endforeach

                        </select>
                        @error('landlord_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Alias</label>
                        <input type="text" class="form-control" name="alias" value="{{ old('alias') }}"
                            placeholder="Nombre corto para rápida identificación">
                        @error('alias')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="bank">Banco</label>
                        <select name="bank" class="custom-select rounded-0">
                            <option value="HSBC">HSBC</option>
                            <option value="Bancomer">Bancomer</option>
                            <option value="Banamex">Banamex</option>
                            <option value="Banorte">Banorte</option>
                            <option selected="selected">
                                {{ old('bank') }}
                            </option>
                        </select>
                        @error('bank')
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
                        <label>Número de cta</label>
                        <input type="text" class="form-control" name="number" value="{{ old('number') }}">
                        @error('number')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <x-adminlte-textarea name="comment" label="Información de la cuenta" rows=5 label-class="text-dark"
                        igroup-size="sm" placeholder="Información Adicional......">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ old('comment') }}
                    </x-adminlte-textarea>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Cuenta Bancaria</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')

    @stop
