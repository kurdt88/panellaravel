<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dependent Dropdown using Ajax Example Laravel - LaravelTuts.com</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="bg-dark text-white mb-4 text-center py-4">
                    <h4>Dependent Dropdown using Ajax Example Laravel - LaravelTuts.com</h4>
                </div>
                <form>
                    <div class="form-group mb-3">

                        <select id="concept-dropdown" class="form-control">
                            <option value="">-- Selecciona el Concepto --</option>

                            <option value="Renta">Renta</option>
                            <option value="Deposito">Deposito</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <select id="lease-dropdown" class="form-control">
                            <option value="">-- Selecciona el Contrato --</option>
                            @foreach ($leases as $lease)
                                <option value="{{ $lease->id }}">
                                    Propiedad:
                                    {{ App\Models\Property::whereId($lease->property)->first()->title }}&nbsp;/&nbsp;
                                    Arrendatario:
                                    {{ App\Models\Tenant::whereId($lease->tenant)->first()->name }}&nbsp;/&nbsp;
                                    Inicio: {{ $lease->start }}&nbsp;Fin:{{ $lease->end }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select id="invoice-dropdown" class="form-control">
                        </select>
                    </div>


                </form>
            </div>
        </div>
    </div>






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            /*------------------------------------------
            --------------------------------------------
            Country Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#lease-dropdown').on('change', function() {
                var idLease = this.value;
                var strconcept = $('#concept-dropdown').val();
                console.log(idLease);
                console.log(strconcept);


                $("#invoice-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-invoices') }}",
                    type: "POST",
                    data: {
                        lease_id: idLease,
                        concept: strconcept,

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#invoice-dropdown').html(
                            '<option value="">-- Selecciona la factura --</option>');
                        $.each(result.invoices, function(key, value) {
                            $("#invoice-dropdown").append('<option value="' + value.id +
                                '">' + 'Mes [' + value.month + ']: ' + value
                                .start_date + ' - ' +
                                value
                                .due_date + '</option>');
                        });
                        // $('#invoice-dropdown').html(
                        //     '<option value="">-- Select Invoice 2 --</option>');
                    }
                });
            });


            $('#concept-dropdown').on('change', function() {
                var strconcept = this.value;
                var idLease = $('#lease-dropdown').val();
                console.log(idLease);
                console.log(strconcept);


                $("#invoice-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-invoices') }}",
                    type: "POST",
                    data: {
                        lease_id: idLease,
                        concept: strconcept,

                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#invoice-dropdown').html(
                            '<option value="">-- Selecciona la factura --</option>');
                        $.each(result.invoices, function(key, value) {
                            $("#invoice-dropdown").append('<option value="' + value.id +
                                '">' + 'Mes [' + value.month + ']: ' + value
                                .start_date + ' - ' +
                                value
                                .due_date + '</option>');
                        });
                        // $('#invoice-dropdown').html(
                        //     '<option value="">-- Select Invoice 2 --</option>');
                    }
                });
            });



        });
    </script>
</body>

</html>
