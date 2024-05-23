@extends('adminlte::page')

@section('title', 'Editar Usuario')

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
            <h3 class="card-title">Editar Usuario: <strong>{{ $user->name }}</strong></h3>
        </div>


        <form method="POST" action="/indexusers/{{ $user->id }}"" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nombre del Usuario</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $user->name }}</b>
                        </small></font>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>{{ $user->email }}</b>
                        </small></font>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                    @error('email')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Asignar un Rol</label>
                    <br>
                    <font color="blue"><small>Valor actual:
                            <b>
                                @if (count($user->getRoleNames()) > 0)
                                    @foreach ($user->getRoleNames() as $role)
                                        <strong>{{ $myrole = $role }} </strong>
                                    @endforeach
                                @else
                                    {{ $myrole = 'sin asignar' }}
                                @endif
                            </b>

                        </small></font>

                    <select id="role" name="role" class="custom-select rounded-0">
                        <option value="">-- Selecciona un rol para el Usuario --</option>
                        <option value="administrador">administrador</option>
                        <option value="operador">operador</option>
                        <option value="auditor">auditor</option>
                        <option value="sin asignar">sin asignar</option>
                        <option selected="selected">
                            {{ $myrole }}
                        </option>
                    </select>
                    @error('role')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>

                <label>Cambiar Password</label>

                <input type="password" class="form-control" name="password">
                @error('password')
                    <p class="text-red">{{ $message }}</p>
                @enderror
                <label>Confirmar nuevo Password</label>

                <input type="password" class="form-control" name="password2">
                @error('password2')
                    <p class="text-red">{{ $message }}</p>
                @enderror



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Editar Usuario</button>

                <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
            </div>
        </form>
    </div>





@stop

@section('css')
@stop

@section('js')

@stop
