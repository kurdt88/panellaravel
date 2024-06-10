@extends('adminlte::page')

@section('title', 'Monitor (Tablero de información)')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <h1>Monitor</h1> --}}

@stop

@section('content')

    @if (auth()->user()->can('view'))
        <div class="container-fluid">

            <div class="row">
                {{-- <div class="col-lg-6 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                {{ Number::Currency($paymentsmxn - $expensesmxn) }}

                            </h3>
                            <p><b>(MXN)</b> Balance total del mes = Ingresos - Egresos =
                                {{ Number::Currency($paymentsmxn) }}
                                -
                                {{ Number::Currency($expensesmxn) }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="/payments" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-6">

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>
                                {{ Number::Currency($paymentsusd - $expensesusd) }}
                            </h3>
                            <p><b>(USD)</b> Balance total del mes = Ingresos - Egresos =
                                {{ Number::Currency($paymentsusd) }}
                                -
                                {{ Number::Currency($expensesusd) }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <a href="/payments" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>
                                @if ($countproperties > 0)
                                    {{ number_format(($countrentedproperties / $countproperties) * 100, 2, '.', ',') }}
                                @else
                                    0
                                @endif

                                <sup style="font-size: 20px">%</sup>
                            </h3>
                            <p>% Ocupación de Unidades: {{ $countrentedproperties }} de {{ $countproperties }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="far fa fa-home""></i>
                        </div>
                        <a href="/properties" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>
                                @if ($countsubproperties > 0)
                                    {{ number_format(($countrentedsubproperties / $countsubproperties) * 100, 2, '.', ',') }}
                                @else
                                    0
                                @endif

                                <sup style="font-size: 20px">%</sup>
                            </h3>
                            <p>% Ocupación de Subunidades:
                                {{ $countrentedsubproperties }} de {{ $countsubproperties }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <a href="/subproperties" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>



                <div class="col-lg-2 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $myoverdueinvoicesarraypayment }}</h3>
                            <p>Cobros (Ingresos) Vencidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-donate"></i>
                        </div>
                        <a href="/invoices_overdue" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">

                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $myoverdueinvoicesarrayexpense }}</h3>
                            <p>Pagos (Egresos) Vencidos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <a href="/invoices_overdue" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $leasesonrenovation }}</h3>
                            <p>Contratos "En Renovación"</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar"></i>
                        </div>
                        <a href="/leases_onrenovation" class="small-box-footer">Mas información <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>






            <div class="row">
                <div class="col-lg-12 col-12">
                    <x-adminlte-card title="Balance de Cuentas Bancarias" theme="dark" icon="fa fa-coins" collapsible
                        removable maximizable>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Banco | Alias</th>
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Propietario</th>
                                    <th scope="col">Ingresos del Mes</th>
                                    <th scope="col">Egresos del Mes</th>
                                    <th scope="col">Balance del Mes</th>

                                    @can('bankaccount')
                                        <th scope="col">Ver Mas</th>
                                    @endcan

                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Models\Account::all() as $account)
                                    <tr>

                                        <td><label style="color:rgb(0, 0, 0) ; font-weight: 500">
                                                <i class="fas fa-coins"></i>
                                                {{ $account->bank }} |
                                                {{ $account->alias }}</label></td>
                                        <td><label
                                                style="color:rgb(0, 0, 0) ; font-weight: 500">{{ $account->number }}</label>
                                        </td>
                                        <td><label
                                                style="color:rgb(0, 0, 0) ; font-weight: 500">{{ $account->landlord->name }}</label>
                                        </td>
                                        <td>

                                            <label style="color:rgb(12, 128, 56)">
                                                <small>{{ $account->type }}</small>
                                                {{ Number::Currency($account->paymentsmonthbalance) }}
                                            </label>

                                        </td>
                                        <td>
                                            <label style="color:rgb(0, 0, 0)">
                                                <small>{{ $account->type }}</small>
                                                {{ Number::Currency($account->expensesmonthbalance) }}
                                            </label>
                                        </td>
                                        <td>

                                            <label style="color:rgb(22, 100, 126)">
                                                <small>{{ $account->type }}</small>
                                                {{ Number::currency($account->monthbalance) }}
                                            </label>
                                        </td>
                                        @can('bankaccount')
                                            <td>
                                                <a href="/accountallmovements/{{ $account->id }}/" class="text-muted">
                                                    <button class="btn btn-xs btn-default text-teal mx-1 shadow"
                                                        title="Details">
                                                        <i class="fa fa-lg fa-fw fa-eye"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-adminlte-card>

                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-6 col-12">
                    <x-adminlte-card title="Cuentas Bancarias (MXN)" theme="primary" icon="fa fa-credit-card" collapsible
                        removable maximizable>
                        <canvas id="cuentasmxn"></canvas>
                    </x-adminlte-card>
                </div>
                <div class="col-lg-6 col-12">
                    <x-adminlte-card title="Cuentas Bancarias (USD)" theme="info" icon="fa fa-credit-card" collapsible
                        removable maximizable>
                        <canvas id="cuentasusd"></canvas>
                    </x-adminlte-card>
                </div>
            </div> --}}

        </div>
    @else
        <x-adminlte-callout theme="info" title-class="text-info text-uppercase" icon="fas fa-lg fa-id-badge"
            title="Su cuenta de usuario no cuenta con autorización para acceder al sistema">
            Por favor <u>contacte al Administrador del sistema</u> para solicitar su acceso.
        </x-adminlte-callout>
    @endif

@stop

@section('css')


@stop

@section('js')

    <script>
        const ctx2 = document.querySelector('#cuentasmxn').getContext('2d');
        const labels2 = {!! json_encode($cuentasmxn->pluck('alias')) !!};

        const stackedLine2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Balance del Mes (MXN)',
                    data: {!! json_encode($cuentasmxn->pluck('monthbalance')) !!},
                    backgroundColor: [
                        'rgba(0, 76, 134, .2)'
                    ],
                    borderColor: [
                        'rgb(0, 76, 134)'
                    ],
                    borderWidth: 1

                }]

            },
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    },
                },
                aspectRatio: 1,
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        fontSize: 12,
                    },
                },

            }
        });





        const ctx3 = document.querySelector('#cuentasusd').getContext('2d');
        const labels3 = {!! json_encode($cuentasusd->pluck('alias')) !!};

        const stackedLine3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: labels3,
                datasets: [{
                    label: 'Balance del Mes (USD)',
                    data: {!! json_encode($cuentasusd->pluck('monthbalance')) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgb(75, 192, 192)'
                    ],
                    borderWidth: 1

                }]

            },
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    },
                },
                aspectRatio: 1,
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        fontSize: 12,
                    },
                },

            }
            // options: {
            //     scales: {
            //         y: {
            //             stacked: true
            //         }
            //     }
            // }
        });
    </script>


@stop
