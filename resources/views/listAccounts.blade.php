@extends('adminlte::page')

@section('title', 'Lista de Cuentas Bancarias')


@section('content_header')
    <x-flash-message />


    <h1>Lista de Cuentas Bancarias
        @can('create')
            <a href="/newaccount" class="btn btn-tool btn-sm">
                [Nueva Cuenta Bancaria] <button class="btn btn-link"><i class="fas fa-plus"></i></button>
            </a>
        @endcan
    </h1>

@stop




@section('content')

    @php
        $heads = ['Propietario', 'Alias', 'Banco', 'Número', 'Divisa', 'Balance del Mes', 'Acciones'];
        $config = [
            'order' => [[5, 'desc']],
        ];
    @endphp


    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" head-theme="light" theme="light" with-buttons
        striped hoverable>


        @foreach ($accounts as $account)
            <tr>
                <td>
                    <img src="/images/account-icon.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    {{ Str::limit(App\Models\Landlord::whereId($account->landlord_id)->first()->name, 20) }}
                </td>
                <td>
                    {{ $account->alias }}
                </td>
                <td> {{ $account->bank }}</td>
                <td> {{ $account->number }}</td>

                <td> {{ $account->type }}</td>


                <td>

                    <label style="color:rgb(22, 100, 126)">
                        <small>{{ $account->type }}</small>
                        {{ Number::currency($account->monthbalance) }}
                    </label>

                </td>

                <div>
                    <td>
                        <a href="/accounts/{{ $account->id }}/" class="text-muted">
                            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                <i class="fa fa-lg fa-fw fa-eye"></i>
                            </button>
                        </a>

                        @can('edit')
                            <a href="/indexaccounts/{{ $account->id }}/edit" class="text-muted">
                                <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </button> </a>
                        @endcan

                        @can('delete')
                            <form style="display:inline;" method="POST" action="/delaccount/{{ $account->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"
                                    onclick="return confirm('¿Estas seguro de querer borrar el registro seleccionado? \n ALERTA Si confirma la información no podrá ser recuperada.')">

                                    <i class="fa fa-lg fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endcan

                    </td>
                </div>
            </tr>
        @endforeach


    </x-adminlte-datatable>






@stop

@section('css')
@stop
