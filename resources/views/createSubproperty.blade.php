@extends('adminlte::page')


@section('title', 'Crear nueva Subunidad')

@section('content_header')
    <x-flash-error-message />
    <x-flash-message />
@stop

@section('content')



    <header class="text-center">

    </header>



    <div class="col-md-12">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crear nueva Subunidad</h3>
            </div>


            <form method="POST" action="/indexsubproperties" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="property_id">Propiedad Asociada</label>
                        <select name="property_id" class="custom-select rounded-0" id="property_id">
                            <option value="">-- Selecciona una Propiedad --</option>

                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}">{{ $property->title }}</option>
                            @endforeach

                        </select>
                        @error('property_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>



                    <label>Propietario</label>

                    <div class="form-group">
                        <select id="landlord-dropdown" name="landlord_id" class="form-control">
                        </select>
                        @error('landlord_id')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select name="type" class="custom-select rounded-0" id="exampleSelectRounded0">
                            <option value="">-- Selecciona el tipo de subunidad --</option>

                            <option value="Estacionamiento">Estacionamiento</option>
                            <option value="Bodega">Bodega</option>
                            <option value="Estudio">Estudio</option>
                            <option value="Depósito de Perro">Depósito de Perro</option>
                            <option value="Otro">Otro</option>
                            {{-- <option selected="selected">
                                {{ old('type') }}
                            </option> --}}
                        </select>
                        @error('type')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tittle">Título</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                            placeholder="Ejemplo: Estacionamiento en Edificio Torrre Portales">
                        @error('title')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <textarea type="text" class="form-control" name="address" id="address" value="{{ old('address') }}"
                            placeholder="Dirección completa"></textarea>
                        @error('address')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rent">Renta Mensual Sugerida</label>
                        <input type="number" min="1" step="any" class="form-control" name="rent"
                            value="{{ old('rent') }}">
                        @error('rent')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label for="deposit">Depósito</label>
                        <input type="number" class="form-control" name="deposit" value="{{ old('deposit') }}">
                        @error('deposit')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="typed">Divisa</label>
                        <select name="typed" class="custom-select rounded-0">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>

                            <option selected="selected">
                                {{ old('typed') }}
                            </option>
                        </select>
                        @error('typed')
                            <p class="text-red">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-adminlte-textarea name="description" label="Información de la Subunidad" rows=2
                        label-class="text-dark" igroup-size="sm"
                        placeholder="Indique todos los detalles de la subunidad......">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-lg fa-file-alt text-light"></i>
                            </div>
                        </x-slot>
                        {{ old('description') }}
                    </x-adminlte-textarea>


                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Crear Subunidad</button>

                    <a href="javascript:history.back()" class="text-black ml-4">Regresar</a>
                </div>
            </form>
        </div>









    @stop

    @section('css')
    @stop

    @section('js')
        <script>
            $(document).ready(function() {
                /*------------------------------------------
                --------------------------------------------
                Country Dropdown Change Event
                --------------------------------------------
                --------------------------------------------*/
                $('#property_id').on('change', function() {
                    var idProperty = this.value;

                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            property_id: idProperty,
                            concept: 'find_property_location',

                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {

                            $('#address').html('');
                            $("#address").append(result);
                            // $('#invoice-dropdown').html(
                            //     '<option value="">-- Select Invoice 2 --</option>');
                        }
                    });


                    $.ajax({
                        url: "{{ url('api/fetch-invoices') }}",
                        type: "POST",
                        data: {
                            property_id: idProperty,
                            concept: 'find_property_landlord',

                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {


                            $('#landlord-dropdown').html(
                                '<option value=0>-- Selecciona un Propietario --</option>'
                            );
                            $.each(result.landlords, function(key, value) {
                                if (value.id != 1) {
                                    $("#landlord-dropdown").append('<option value="' +
                                        value
                                        .id +
                                        '">' + value.name + '</option>');
                                }
                            });





                        }
                    });




                });




            });
        </script>
    @stop
