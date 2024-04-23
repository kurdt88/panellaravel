@extends('adminlte::page')

@section('title', 'Mostrando Egreso')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    {{-- <p>Mostrando propiedad: {{ $property->title }}</p> --}}

@stop

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Detalles del Egreso</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Regresar</a></li>
                        <li class="breadcrumb-item active"><a href="/indexexpenses/{{ $expense->id }}/edit/">Editar</a></li>
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
                        <h2><strong> <i class="fas fa-hand-holding-usd fa-fw fa-fw">
                                </i>
                                {{ $expense->invoice->comment }}
                            </strong>
                        </h2>

                        <h2>

                            @if (is_null($expense->rate_exchange))
                                {{ $expense->type }}@else{{ $expense->type }}
                            @endif
                            @if (is_null($expense->rate_exchange))
                                {{ Number::currency($expense->ammount) }}
                                @else{{ Number::currency($expense->ammount_exchange) }}
                            @endif

                            <small> | <font color="gray">{{ $expense->invoice->concept }}</font>
                            </small>
                        </h2>


                        <p class="lead mb-5">


                        </p>
                    </div>
                </div>

                <div class="col-7">
                    <div class="form-group">

                        @if ($expense->lease->id != 1)
                            <label>Propiedad </label>

                            @if ($expense->lease->subproperty_id != 1)
                                <a href="/subproperties/{{ $expense->invoice->subproperty_id }}">
                                    <small>
                                        [+ Ver Propiedad]
                                    </small>
                                </a>


                                <input type="text" value="{{ $expense->lease->subproperty_name }}" class="form-control"
                                    disabled />
                            @else
                                <a href="/properties/{{ $expense->lease->property }}">
                                    <small>
                                        [+ Ver Propiedad]
                                    </small>
                                </a>


                                <input type="text"
                                    value="{{ App\Models\Property::whereId($expense->lease->property)->first()->title }}"
                                    class="form-control" disabled />
                            @endif
                        @else
                            <label>Propiedad </label>

                            @if ($myprop_id = $expense->invoice->property_id)
                                <a href="/properties/{{ $myprop_id }}/">
                                    <small>
                                        [+ Ver Propiedad]
                                    </small>
                                </a>
                                <input type="text"
                                    value="{{ App\Models\Property::whereid($myprop_id)->first()->title }}"
                                    class="form-control" disabled />
                            @endif
                            @if ($mysubprop_id = $expense->invoice->subproperty_id)
                                <a href="/subproperties/{{ $mysubprop_id }}/">
                                    <small>
                                        [+ Ver Propiedad]
                                    </small>
                                </a>
                                <input type="text"
                                    value="{{ App\Models\Subproperty::whereid($mysubprop_id)->first()->title }}"
                                    class="form-control" disabled />
                            @endif


                        @endif

                        <label for="inputName">Cuenta Bancaria de donde se obtuvo el recurso <a
                                href="/accounts/{{ $expense->account_id }}/">
                                <small>[+ Ver Cuenta Bancaria]</small></a></label>
                        <input type="text"
                            value="[Divisa: {{ $expense->account->type }}] | Banco: {{ $expense->account->bank }} | Alias: {{ $expense->account->alias }} | Cuenta: {{ $expense->account->number }} | Propietario: {{ $expense->account->owner }} "
                            class="form-control" disabled />


                        <label>Monto Total <small>(+IVA)</small> del Recibo asociado </label><a
                            href="/invoices/{{ $expense->invoice_id }}/">
                            <small>[+ Ver Recibo Asociado]</small></a>
                        <input type="text"
                            value="{{ $expense->invoice->type }} {{ Number::currency($expense->invoice->total) }}"
                            class="form-control" disabled />

                        {{-- <label for="inputName">Monto del Egreso</label>
                        <input type="text"
                            value="@if (is_null($expense->rate_exchange)) {{ $expense->type }}@else{{ $expense->type }} @endif @if (is_null($expense->rate_exchange)) {{ Number::currency($expense->ammount) }}
                                                @else{{ Number::currency($expense->ammount_exchange) }} @endif
                        "
                            class="form-control" disabled /> --}}


                        @if ($expense->rate_exchange)
                            <label>Tipo de cambio* de la operación y monto en
                                {{ $expense->invoice->type }}<br>
                                <small>* (Pesos por Dolar)</small>
                            </label>
                            <input type="text"
                                value="{{ $expense->rate_exchange }}   /   {{ $expense->invoice->type }}$ {{ $expense->ammount }}"
                                class="form-control" disabled />
                        @endif


                        <label for="inputName">Fecha</label>
                        <input type="text" value="{{ $expense->date }}" class="form-control" disabled />

                        <label for="inputName">Proveedor del bien o servicio</label>
                        <input type="text"
                            value="{{ App\Models\Supplier::whereId($expense->supplier_id)->first()->name }}"
                            class="form-control" disabled />

                        <label for="inputMessage">Información Adicional</label>
                        <textarea class="form-control" rows="1" disabled>{{ $expense->description }}</textarea>

                        @if ($expense->maintenance_budget == 1)
                            <font color="blue">Este Egreso afectó el <i>Presupuesto de
                                    Mantenimiento</i> de la <a href="/buildings/">Unidad Habitacional [+]<a></font>
                        @endif
                    </div>
                    <a href="/invoices/{{ $expense->invoice_id }}/" rel="noopener" class="btn btn-success float-right"><i
                            class="fa fa-lg fa-fw fa-eye"></i> Ver Recibo</a> &nbsp;
                    <button onClick="window.print()" type="button" class="btn btn-warning float-right"
                        style="margin-right: 5px;">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                    <button type="button" onClick="location.href='/suppliers/{{ $expense->supplier_id }}'"
                        class="btn btn-dark float-right" style="margin-right: 5px;">
                        <i class="fas fa-briefcase"></i> Ver Proveedor
                    </button>
                    {{-- <button type="button" onClick="location.href='/indexexpenses/{{ $expense->id }}/edit/'"
                        class="btn btn-secondary float-right" style="margin-right: 5px;">
                        <i class="fas fa-edit"></i> Editar
                    </button> --}}
                </div>

            </div>

        </div>




        <div class="col-12">

            <label>
                <i class="fas fa-camera-retro">
                </i> Imágenes : </label>
            <div class="card">

                <div class="row mb-3 col-10">


                    <div class="col-12 product-image-thumbs">
                        @foreach ($expense->expenseimgs as $expenseimg)
                            @if ($expenseimg->type == 'image')
                                <a href="{{ asset('storage/' . $expenseimg->image) }}">
                                    <div class="product-image-thumb">
                                        <img width="300" height="auto"
                                            src="{{ $expenseimg->image ? asset('storage/' . $expenseimg->image) : asset('/images/no-image.png') }}"
                                            alt="{{ $expenseimg->original_name }}" />
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">


            <label>
                <i class="fas fa-file-pdf">
                </i> Archivos : </label>
            <div class="card">
                <ul>
                    @foreach ($expense->expenseimgs as $expenseimg)
                        @if ($expenseimg->type == 'file')
                            <a href="{{ asset('storage/' . $expenseimg->image) }}">
                                <li>{{ $expenseimg->original_name }}</li>
                            </a>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>


        <br>
    </section>






@stop

@section('css')
@stop

@section('js')

@stop
