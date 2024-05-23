@extends('adminlte::page')

@section('title', 'Detalle de Cuenta Bancaria')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detalle de Cuenta Bancaria</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        @can('edit')
                            <li class="breadcrumb-item active"><a href="/indexaccounts/{{ $account->id }}/edit">Editar</a></li>
                        @endcan

                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class>
                        <h2><strong> <i class="fas fa-coins">
                                </i>
                                {{ $account->alias }}

                            </strong>
                            {{-- <a href="/accounts/{{ $account->id }}">
                                <small>
                                    [+]
                                </small> --}}
                        </h2>



                        <p class="lead mb-5">
                            <i class='fas fa-landmark fa-sm'> </i>
                            {{ $account->bank }} | {{ $account->number }}
                        </p>


                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">
                        <label>Propietario de la cuenta</label>
                        <a href="/landlords/{{ $account->landlord_id }}"><small>[+ Ver Propietario]</small>
                        </a>
                        <input type="text"
                            value="{{ Str::limit(App\Models\Landlord::whereId($account->landlord_id)->first()->name, 20) }}"
                            class="form-control" disabled />




                        <label for="inputName">Banco</label>
                        <input type="text" value=" {{ $account->bank }}" class="form-control" disabled />

                        <label for="inputName"># Cuenta</label>
                        <input type="text" value=" {{ $account->number }}" class="form-control" disabled />


                        <label for="inputName">Moneda</label>
                        <input type="text" value=" {{ $account->type }}" class="form-control" disabled />


                        <label for="inputMessage">Información Adicional</label>
                        <textarea class="form-control" rows="2" disabled>{{ $account->comment }}</textarea>
                        {{-- <br>
                        <label> [+] <a href="/accountmonthmovements/{{ $account->id }}/"> Movimientos del mes </a></label>
                        <br>
                        <label> [+] <a href="/accountallmovements/{{ $account->id }}/"> Todos los movimientos </a></label>
                        <br>
                        <label> [+] <a href="/accountsearchmovements/{{ $account->id }}/"> Más movimientos
                            </a></label> --}}

                        <div class="row no-print">
                            <div class="col-12">

                                <br>

                                <a href="/accountmonthmovements/{{ $account->id }}/" class="text-muted">

                                    <button type="button" class="btn btn-warning float-right" style="margin-right: 5px;">
                                        <i class="fas fa-calendar"></i> Movimientos del mes
                                    </button>
                                </a>

                                <a href="/accountallmovements/{{ $account->id }}/" class="text-muted">

                                    <button type="button" class="btn btn-secondary float-right" style="margin-right: 5px;">
                                        <i class="far fa-calendar-alt"></i> Todos los movimientos
                                    </button>
                                </a>
                                @can('edit')
                                    <button onClick="location.href='/indexaccounts/{{ $account->id }}/edit'" type="button"
                                        class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-pen-alt"></i> Editar
                                    </button>
                                @endcan
                                <button onClick="location.href='/accountsearchmovements/{{ $account->id }}/'"
                                    type="button" class="btn btn-dark float-right" style="margin-right: 5px;">
                                    <i class="fas fa-coins"></i> Más movimientos
                                </button>

                                {{-- <button onClick="location.href='/accounts/'" type="button"
                                    class="btn btn-success float-right" style="margin-right: 5px;">
                                    <i class="fas fa-coins"></i> Todas las Cuentas
                                </button> --}}

                            </div>

                        </div>
                    </div>
                </div>



            </div>

        </div>







    </section>






@stop

@section('css')
@stop

@section('js')

@stop
