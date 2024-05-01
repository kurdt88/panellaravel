@extends('adminlte::page')

@section('title', 'Buscar Movimientos en Presupuesto')


@section('content_header')
    <x-flash-message />
    <x-flash-error-message />



    <h1>Buscar Movimientos del Presupuesto de Mantenimiento<h6>Unidad Habitacional: <strong>
                {{ $building->name }}</strong></h6>
    </h1>

@stop




@section('content')

    <div class="card card-primary">
        <form method="POST" action="/budgetmovements/{{ $building->id }}" enctype="multipart/form-data">
            @csrf
            @php
                $config = [
                    // 'timePicker' => true,
                    'endDate' => 'js:moment()',
                    'startDate' => 'js:moment()',
                    'locale' => ['format' => 'YYYY-MM-DD'],
                ];
            @endphp
            <x-adminlte-date-range name="searchperiod" label="Periodo de búsqueda" :config="$config">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-primary">
                        <i class="far fa-lg fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Buscar movimientos</button>
                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
