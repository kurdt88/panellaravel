@extends('adminlte::page')

@section('title', 'Presupuestos de Mantenimiento')

@section('content_header')
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Presupuestos de Mantenimiento en <strong>{{ $building->name }}</strong></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/buildings/{{ $building->id }}">Regresar a Unidad
                                Habitacional</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:window.print()">Imprimir</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">



        <div class="card">
            <div class="card-body row">
                <div class="col-12">
                    <label>Lista de Presupuestos de Mantenimiento:</i></label>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Edificio</th>
                                <th scope="col">Año / Mes</th>
                                <th scope="col">Monto en MXN</th>
                                <th scope="col">Monto en USD</th>
                                <th scope="col">Comentario</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($building->budgets as $budget)
                                <tr>
                                    <td>{{ App\Models\Building::whereid($budget->building_id)->get()->first()->name }}<a
                                            href="/buildings/{{ $budget->building_id }}"> [+]</a>
                                    </td>
                                    <td>{{ $budget->year }} / {{ $budget->month }} </td>
                                    <td>
                                        {{ Number::Currency($budget->maintenance_budget_mxn) }}
                                    </td>
                                    <td>
                                        {{ Number::Currency($budget->maintenance_budget_usd) }}
                                    </td>
                                    <td>
                                        {{ Str::limit($budget->comment, 25) }}
                                    </td>

                                    <td>

                                        <a href="/indexbudgets/{{ $budget->id }}/edit" class="text-muted">
                                            <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                                <i class="fa fa-lg fa-fw fa-pen"></i>
                                            </button> </a>

                                        <form style="display:inline;" method="POST"
                                            action="/delbudget/{{ $budget->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                                <i class="fa fa-lg fa-fw fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">

                    <button type="button" onClick="location.href='/newbudget/{{ $building->id }}'"
                        class="btn btn-secondary float-right" style="margin-right: 5px;">
                        <i class="fas fa-upload"></i> Registrar Presupuesto de Mtto
                    </button>
                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>

        </div>
    </section>






@stop

@section('css')
@stop

@section('js')

@stop
