@extends('adminlte::page')

@section('title', 'Tablero de información')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <h1>Tablero de información</h1>

@stop

@section('content')



    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            {{ Number::currency(
                                DB::table('payments')->whereBetween('created_at', ['2024-01-01', '2024-12-01'])->sum('ammount'),
                            ) }}


                        </h3>
                        <p>Pagos registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-balance-scale"></i>
                    </div>
                    <a href="/payments" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ count($properties) }}<sup style="font-size: 20px">%</sup>
                        </h3>
                        <p>Propiedades Registradas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ count($tenants) }}</h3>
                        <p>Número de Arrendatarios</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="/tenants" class="small-box-footer">Mas información <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ count($leases) }}</h3>
                        <p>Contratos celebrados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-exclamation-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">Mas información <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>



        {{-- <p>
        <blockquote class="quote-danger">
            <h5 id="note">Avisos!</h5>
            <p>Avisos importantes</p>
        </blockquote>
        </p> --}}
        <div class="row">

            <div class="col-lg-6 col-12">

                <x-adminlte-card title="Pagos por tipo" theme="primary" icon="fa fa-credit-card" collapsible removable
                    maximizable>
                    <canvas id="pagosPorTipo"></canvas>
                    {{-- {{ $resultados }} --}}
                </x-adminlte-card>
            </div>

            {{--
            <div class="col-lg-6 col-12">


                <x-adminlte-card title="Pagos por concepto" theme="secondary" icon="fa fa-archive" collapsible removable
                    maximizable>
                    <canvas id="pagosPorConcepto"></canvas>
                </x-adminlte-card>
            </div> --}}
        </div>

    </div>

@stop

@section('css')


@stop

@section('js')

    <script>
        const ctx2 = document.querySelector('#pagosPorTipo').getContext('2d');
        const labels2 = {!! json_encode($resultados->pluck('type')) !!};

        const stackedLine2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Pagos por tipo',
                    data: {!! json_encode($resultados->pluck('total')) !!},
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
                // indexAxis: 'y',
                scales: {
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>


@stop
