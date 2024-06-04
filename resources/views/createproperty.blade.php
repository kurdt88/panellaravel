@extends('adminlte::page')

@section('title', 'Crear una nueva Unidad')

@section('content_header')
    {{-- <h1>Propiedades<b>LTE</b></h1> --}}
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')



    <header class="text-center">
        {{-- <h2 class="text-2xl font-bold uppercase mb-1">
            Crear una nueva propiedad
        </h2> --}}
    </header>



    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crear una nueva Unidad</h3>
            </div>


            <form method="POST" action="/indexproperties" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="building_id">Conjunto Habitacional</label>
                        <select name="building_id" class="custom-select rounded-0" id="building_id">
                            <option value="">-- Selecciona un Conjunto Habitacional --</option>

                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}">{{ $building->name }}</option>
                            @endforeach
                        </select>

                        @error('building_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="landlord_id">Propietario</label>
                        <select name="landlord_id" class="custom-select rounded-0" id="landlord_id">
                            <option value="">-- Selecciona un Propietario --</option>

                            @foreach ($landlords as $landlord)
                                @if ($landlord->id != 1)
                                    <option value="{{ $landlord->id }}">{{ $landlord->name }}</option>
                                @endif
                            @endforeach

                        </select>
                        @error('landlord_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tittle">Título</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                            placeholder="Nombre corto para identificar a la Unidad">
                        @error('title')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida (avalúo)</label>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ old('rent') }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="type">Divisa</label>
                        <select name="type" class="custom-select rounded-0">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>

                            <option selected="selected">
                                {{ old('type') }}
                            </option>
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="location">Ubicación</label>
                        <textarea type="text" class="form-control" name="location" id="location" value="{{ old('location') }}"
                            placeholder="Dirección completa"></textarea>
                        @error('location')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="description">Descripción de la propiedad</label>

                        <textarea class="form-control" name="description" rows="3"
                            placeholder="Incluye todos los detalles de la propiedad.">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Unidad</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar </a>
                </div>
            </form>
        </div>









    @stop

    @section('js')
        <script>
            $(document).ready(function() {
                /*------------------------------------------
                --------------------------------------------
                Country Dropdown Change Event
                --------------------------------------------
                --------------------------------------------*/
                $('#building_id').on('change', function() {
                    var idBuilding = this.value;

                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            building_id: idBuilding,
                            concept: 'find_building_address',

                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {

                            $('#location').html('');
                            $("#location").append(result);
                            // $('#invoice-dropdown').html(
                            //     '<option value="">-- Select Invoice 2 --</option>');
                        }
                    });
                });




            });
        </script>
    @stop
