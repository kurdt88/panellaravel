@extends('adminlte::page')

@section('title', 'Crear Presupuesto de Mantenimiento')

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
            <h3 class="card-title">Registrar Presupuesto de Mantenimiento <strong> |
                    {{ $building->name }}</strong> </h3>
        </div>


        <form method="POST" action="/indexbudgets" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <input type="hidden" id="building_id" name="building_id" value="{{ $building->id }}">
                <input type="hidden" id="building" name="building" value="{{ $building }}">


                <div class="form-group">
                    <label>Seleccione el Mes</label>

                    <div>
                        <input type="month" name="date" onkeydown="return false" style="color:gray" />

                    </div>
                    </label>
                    @error('date')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>




                <div class="form-group">
                    <label>Presupuesto en MXN</label> <small> * Campo Opcional | default 0</small>

                    <input type="number" step="any" id="maintenance_budget_mxn" name="maintenance_budget_mxn"
                        class="custom-select rounded-0" value="0"></input>
                    @error('maintenance_budget_mxn')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Presupuesto en USD</label> <small> * Campo Opcional | default 0</small>

                    <input type="number" step="any" id="maintenance_budget_usd" name="maintenance_budget_usd"
                        class="custom-select rounded-0" value="0"></input>
                    @error('maintenance_budget_usd')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <label>Información Adicional</label> <small> * Campo Opcional</small>
                <x-adminlte-textarea name="comment" rows=1 label-class="text-dark" igroup-size="sm"
                    placeholder="Información Adicional del presupuesto de mantenimiento.">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-secondary">
                            <i class="fas fa-lg fa-file-alt text-light"></i>
                        </div>
                    </x-slot>
                    {{ old('comment') }}
                </x-adminlte-textarea>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Registrar Presupuesto</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
