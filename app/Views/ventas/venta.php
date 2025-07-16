<?php
$idVentaTmp = uniqid();
?>

<main>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <form id="form_venta" name="form_venta" class="form-horizontal"
            method="POST" action="<?= base_url() ?>ventas/guardar" autocomplete="off">
            <input type="hidden" id="id_venta" name="id_venta" value="<?= $idVentaTmp ?>" />
            <input type="hidden" id="id_producto" name="id_producto" />
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="ui-widget">
                            <label>Cliente:</label>
                            <input type="hidden" id="id_cliente" name="id_cliente" value="1" />
                            <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escribe el Nombre del cliente"
                                value="Cliente Anónimo" onkeyup="" autocomplete="off" required />
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label>Forma de Pago:</label>
                        <select id="forma_pago" name="forma_pago" class="form-control" required>
                            <option value="001">Efectivo</option>
                            <option value="002">Tarjeta Crédito/Débito</option>
                            <option value="003">Transferencia</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <label>Código: </label>
                        <input autofocus class="form-control" id="codigo" name="codigo"
                            placeholder="Escribe el código y presiona Enter" type="text"
                            onkeyup="buscarProducto(event, this, this.value)" />
                        <label id="resultado_error" for="codigo" style="color: red;"></label>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label>Nombre Producto: </label>
                        <input disabled class="form-control" id="nombre" name="nombre" type="text" />
                    </div>

                    <div class="col-12 col-sm-4">
                        <label>Cantidad: </label>
                        <input onkeyup="valida(this)" value="" class="form-control" id="cantidad" name="cantidad" type="number" />
                    </div>
                </div>
            </div>






            <div class="row">
                <button type="button" id="completa_venta" class="btn btn-success  mb-2 ">Completar Venta</button>
                <div class="col-12 col-sm-6 offset-md-4 ">
                    <label style="font-weight: bold; font-size: 30px; text-align: center;">Total:</label>
                    <span class="align-baseline"><input type="text" class="text-center" text id="total" name="total" size="6" readonly="true" value="0"
                            style="font-weight: bold; font-size: 25px; text-align: left;" />
                        <input type="hidden" value="" id="total_numero" name="total_numero" />

                    </span>
                </div>

            </div>


            <div class="row">
                <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos">
                    <thead class="thead-dark text-center">
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio $</th>
                        <th>Cantidad</th>
                        <th>Total $</th>
                        <th width="1%">#</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </form>

    </div>
</main>

<script>
    $(function() {
        $("#cliente").autocomplete({
            source: "<?= base_url() ?>clientes/autoCompleteData/",
            minLength: 3,
            select: function(event, ui) {
                event.preventDefault();
                $("#id_cliente").val(ui.item.id);
                $("#cliente").val(ui.item.value);
            }
        });
    });


    $(function() {
        $("#codigo").autocomplete({
            source: "<?= base_url() ?>productos/autoCompleteData/",
            minLength: 3,
            select: function(event, ui) {
                event.preventDefault();
                $("#id_producto").val(ui.item.id);
                $("#codigo").val(ui.item.value);
                $("#nombre").val(ui.item.nombre);
                if ($("#cantidad").val() <= 0) {
                    $("#cantidad").val(1);
                }
                $("#cantidad").select();
                $("#cantidad").focus();

                setTimeout(
                    function() {
                        e = jQuery.Event("keypress");
                        e.wich = 13;
                        agregarProducto($("#id_producto").val(), $("#cantidad").val(), '<?= $idVentaTmp ?>');
                    }
                )
            }
        });
    });


    function agregarProducto(id_producto, cantidad, id_venta) {
        if (id_producto != null && id_producto != 0 && cantidad > 0) {


            $.ajax({
                url: '<?= base_url() ?>temporalmovimiento/insertar/' + id_producto + '/' + cantidad + '/' + id_venta + '/' + 'venta',
                dataType: 'json',
                success: function(resultado) {
                    if (resultado == 0) {

                    } else {
                        //var datos = JSON.parse(resultado.datos);

                        if (resultado.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(resultado.datos);
                            $("#total").val(resultado.total);
                            $("#total_numero").val(resultado.total_numero);

                            $("#id_producto").val('');
                            $("#codigo").val('');
                            $("#nombre").val('');
                            $("#cantidad").val('');
                            $("#precio").val('');
                            $("#subtotal").val('');

                            $("#codigo").focus();

                        }
                    }
                }
            })

        }
    };

    function valida(campo) {
        if (isNaN(campo.value) || campo.value == ' ') {
            campo.value = 1;
        }
    };


    function buscarProducto(e, tagCodigo, codigo) {
        var enterKey = 13;

        if (codigo != '') {

            if (e.which == enterKey) {

                $.ajax({
                    url: '<?= base_url() ?>productos/buscarPorCodigo/' + codigo,
                    dataType: 'json',
                    success: function(resultado) {
                        if (resultado == 0) {
                            $(tagCodigo).val('');
                        } else {
                            $(tagCodigo).removeClass('has-error');
                            $("#resultado_error").html(resultado.error);

                            if (resultado.existe) {
                                $("#id_producto").val(resultado.datos.id);
                                $("#nombre").val(resultado.datos.nombre);
                                if ($("#cantidad").val() <= 0) {
                                    $("#cantidad").val(1);
                                }
                                $("#precio").val(resultado.datos.precio_venta);
                                $("#subtotal").val(resultado.datos.precio_venta);
                                agregarProducto($("#id_producto").val(), $("#cantidad").val(), '<?= $idVentaTmp ?>');
                            } else {
                                $("#id_producto").val('');
                                $("#nombre").val('');
                                $("#cantidad").val('');
                                $("#precio").val('');
                                $("#subtotal").val('');
                            }
                        }
                    }
                })
            }
        }
    };


    function eliminarProducto(id_producto, id_compra) {
        if (id_producto != null && id_producto != 0 ) {


            $.ajax({
                url: '<?= base_url() ?>temporalmovimiento/eliminar/' + id_producto + '/' + id_compra,
                dataType: 'json',
                success: function(resultado) {
                    if (resultado == 0) {

                    } else {
                        //var datos = JSON.parse(resultado.datos);

                        if (resultado.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(resultado.datos);
                            $("#total").val(resultado.total);
                            $("#total_numero").val(resultado.total_numero);



                        }
                    }
                }
            })

        }

    };


    $(document).ready(function() {
        $("#completa_venta").click(function(){
            let nFila = $("#tablaProductos tr").length;
            if(nFila<2){
                alert('No hay productos!');
            }
            else{
                $("#form_venta").submit();
            }
        });
    });
</script>