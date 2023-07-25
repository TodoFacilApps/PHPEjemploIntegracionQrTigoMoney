<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ejemplo - Integración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="antialiased">
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-center">
                <h3>PagoFacil QR</h3>
                <p class="blue-text">Proyecto de ejemplo de integración de servicios PagoFacil.<br></p>
                <div class="card">
                    <h5 class="text-center mb-4">Laravel</h5>
                    <form id="FormIntegrar" class="form-card" action="/consumirServicio" method="POST" target="QrImage">
                        @csrf
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Razon Social</label>
                                <input type="text" name="tcRazonSocial" placeholder="Nombre del Usuario">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">CI/NIT</label>
                                <input type="text" name="tcCiNit" placeholder="Número de CI/NIT">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Celular</label>
                                <input type="text" name="tnTelefono" placeholder="Número de Teléfono">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Correo</label>
                                <input type="text" name="tcCorreo" placeholder="Correo Electrónico">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Monto Total</label>
                                <input type="text" name="tnMonto" placeholder="Costo Total">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Tipo de Servicio</label>
                                <select name="tnTipoServicio" class="form-control">
                                    <option value="1">Servicio QR</option>
                                    <option value="2">Tigo Money</option>
                                </select>
                            </div>

                        </div>
                        <h5 class="text-center mt-4">Datos del Producto</h5>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-4 flex-column d-flex">
                                <label class="form-control-label px-3">Serial</label>
                                <input type="text" name="taPedidoDetalle[0][Serial]" placeholder="">
                            </div>
                            <div class="form-group col-sm-4 flex-column d-flex">
                                <label class="form-control-label px-3">Producto</label>
                                <input type="text" name="taPedidoDetalle[0][Producto]" placeholder="">
                            </div>
                            <div class="form-group col-sm-4 flex-column d-flex">
                                <label class="form-control-label px-3">Cantidad</label>
                                <input type="text" name="taPedidoDetalle[0][Cantidad]" placeholder="">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-4 flex-column d-flex">
                                <label class="form-control-label px-3">Precio</label>
                                <input type="text" name="taPedidoDetalle[0][Precio]" placeholder="">
                            </div>
                            <div class="form-group col-sm-4 flex-column d-flex">
                                <label class="form-control-label px-3">Descuento</label>
                                <input type="text" name="taPedidoDetalle[0][Descuento]" placeholder="">
                            </div>
                            <div class="form-group col-sm-4 flex-column d-flex">
                                <label class="form-control-label px-3">Total</label>
                                <input type="text" name="taPedidoDetalle[0][Total]" placeholder="">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-sm-6">
                                <button type="submit" class="btn-block btn-primary">Consumir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-12 py-5">
                <div class="row d-flex justify-content-center">
                    <iframe name="QrImage" style="width: 100%; height: 495px;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#FormIntegrar').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '{{ route("/consultar") }}',
                    type: 'POST',
                    data: $('#tnTransaccion').serialize(),
                    success: function(response) {
                        // Aquí puedes manejar la respuesta del controlador
                        console.log(response.message);
                    },
                    error: function(error) {
                        // Manejar errores, si es necesario
                        console.error(error);
                    }
                });
            });
        });
    </script>

</body>

</html>