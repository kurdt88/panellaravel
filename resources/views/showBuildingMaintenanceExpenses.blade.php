@extends('adminlte::page')

@section('title', 'Lista de Gastos')

@section('content_header')

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Afectaciones (del mes) al Presupuesto de Mtto <strong>{{ $building->name }}</strong></h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        <li class="breadcrumb-item active">Imprimir</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <?php $usd_expenses = 0; ?>
        <?php $mxn_expenses = 0; ?>

        <div class="card">
            <div class="card-body row">
                <div class="col-12">
                    <label>Lista de Egresos:</i></label>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Propiedad</th>

                                <th scope="col">Descripción</th>
                                <th scope="col">Ver Mas</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>
                                        <img src="/images/expense-icon.png" alt="Product 1"
                                            class="img-circle img-size-32 mr-2">
                                        {{ $expense->date }}
                                    </td>
                                    <td>

                                        <small>(-) </small>

                                        @if (is_null($expense->rate_exchange))
                                            <small>{{ $expense->type }}</small> {{ Number::currency($expense->ammount) }}
                                            <?php
                                            if ($expense->type == 'USD') {
                                                $usd_expenses += $expense->ammount;
                                            }
                                            if ($expense->type == 'MXN') {
                                                $mxn_expenses += $expense->ammount;
                                            }
                                            
                                            ?>
                                        @else
                                            <small>{{ $expense->type }}</small>
                                            {{ Number::currency($expense->ammount_exchange) }}
                                            <?php
                                            if ($expense->type == 'USD') {
                                                $usd_expenses += $expense->ammount_exchange;
                                            }
                                            if ($expense->type == 'MXN') {
                                                $mxn_expenses += $expense->ammount_exchange;
                                            }
                                            
                                            ?>
                                            <font color="gray">(<small>{{ $expense->invoice->type }}</small>
                                                {{ Number::currency($expense->ammount) }})</font>
                                        @endif



                                    </td>

                                    <td>
                                        @if ($expense->invoice->lease->id == 1)
                                            {{ App\Models\Property::whereid($expense->invoice->property_id)->first()->title }}
                                        @else
                                            {{ $expense->invoice->lease->property_->title }}
                                        @endif


                                    </td>

                                    <td>
                                        {{ Str::limit($expense->description, 40) }} |
                                        {{ Str::limit($expense->invoice->comment, 40) }}


                                    </td>

                                    <td>
                                        <a href="/expenses/{{ $expense->id }}/" class="text-muted">
                                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                <i class="fa fa-lg fa-fw fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-adminlte-card theme="primary" theme-mode="outline">

            Periodo | <label style="background-color:rgba(231, 244, 197, 0.829);">{{ $period }} </label><br>

            Presupuesto de Mtto (MXN):
            <font color="green">
                {{-- {{ Number::currency($building->maintenance_budget) }} --}}
                {{ Number::currency($budget_mxn) }}

            </font> |
            Total afectación Presupuesto de Mtto (MXN):
            <font color="#A48000">
                <small>(-) </small>{{ Number::currency($mxn_expenses) }}
            </font><br><br>

            Presupuesto de Mtto (USD):
            <font color="blue">
                {{-- {{ Number::currency($building->maintenance_budget_usd) }} --}}
                {{ Number::currency($budget_usd) }}

            </font> |
            Total afectación Presupuesto de Mtto (USD):
            <font color="#A48000">
                <small>(-) </small>{{ Number::currency($usd_expenses) }}
            </font><br><br>


            Balance del Periodo:<br>
            <label style="color:rgb(22, 100, 126)">
                <small>Presupuesto MXN</small>
                {{ Number::currency($budget_mxn - $mxn_expenses) }}
            </label>
            <label style="color:rgb(22, 100, 126)">
                <small> | Presupuesto USD</small>
                {{ Number::currency($budget_usd - $usd_expenses) }}
            </label><br>


            <button onClick="window.print()" type="button" class="btn btn-warning float-right" style="margin-right: 5px;">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button onClick="location.href='/searchbudgetmovements/{{ $building->id }}'" type="button"
                class="btn btn-dark float-right" style="margin-right: 5px;">
                <i class="fas fa-coins"></i> Más movimientos
            </button>
            @can('create')
                <button type="button" onClick="location.href='/newbudget/{{ $building->id }}'"
                    class="btn btn-secondary float-right" style="margin-right: 5px;">
                    <i class="fas fa-upload"></i> Registrar Presupuesto de Mtto
                </button>
            @endcan
        </x-adminlte-card>
    </section>






@stop

@section('css')
@stop

@section('js')

@stop
