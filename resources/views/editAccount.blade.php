@extends('adminlte::page')


@section('title', 'Panel de Inicio')

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


            <form method="POST" action="/indexaccounts/{{ $account->id }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="landlord_id">Propietario</label>
                        <select name="landlord_id" class="custom-select rounded-0">
                            @foreach ($landlords as $landlord)
                                @if ($landlord->id == $account->landlord_id)
                                    <option value="{{ $landlord->id }}" selected>{{ $landlord->name }}</option>
                                @else
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
                        <input type="text" class="form-control" name="alias" value="{{ $account->alias }}"
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
                                {{ $account->bank }}
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
                                {{ $account->type }}
                            </option>
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Número de cta</label>
                        <input type="text" class="form-control" name="number" value="{{ $account->number }} ">
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
