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
                <input type="hidden" id="id_cliente" name="id_cliente" value="1" />

                <div class="row">
                    <div class="col-sm-5">
                        <div class="ui-widget">
                            <label>Cliente:</label>

                            <input type="text" readonly class="form-control" id="cliente" name="cliente" placeholder="Escribe el Nombre del cliente y selecciona"
                                value="Cliente Anónimo" onkeyup="" autocomplete="off" required />
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="anonimo" name="anonimo" checked />
                                <label class="form-check-label" for="anonimo">Anónimo?</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
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
                        <input class="form-control" id="nombre" name="nombre" type="text" />
                    </div>

                    <div class="col-12 col-sm-4">
                        <label>Cantidad: </label>
                        <input onkeyup="valida(this)" value="" class="form-control" id="cantidad" name="cantidad" type="number" />
                        <input value="" class="form-control" id="precio" name="precio" type="hidden" />
                    </div>
                </div>
            </div>






            <div class="row">
                <button type="button" id="completa_venta" class="btn btn-success  mb-2 "><i class="fas fa-check"></i> Completar Venta</button>
                <button type="button" data-toggle="modal" data-target="#modal-manual" id="venta_manual" class="btn btn-primary ml-2 mb-2 "><i class="fas fa-cart-plus"></i> Item Manual</button>
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
                        <th>Precio </th>
                        <th>Cantidad</th>
                        <th>Total </th>
                        <th width="1%">#</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="mt-3" style="position: relative; height: 100px;">
                <button style="position: absolute;
  bottom: 5px;
  right: 5px; 
  width: 200px;" type="button" data-toggle="modal" data-target="#modal-confirma" data-href="<?= base_url() ?>cajas/cerrar" id="cerrar_caja" class="btn btn-danger  mb-2 boton-inferior"><i class="fas fa-lock"></i> Cerrar Caja</button>

            </div>

        </form>

    </div>
</main>


<!-- Modal confirmación -->
<div class="modal fade" id="modal-confirma" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cerrar Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea cerrar la caja?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a type="button" class="btn btn-danger btn-ok">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal alerta -->
<div class="modal fade" id="modal-alerta" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atención</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="text-alerta"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal manual -->
<div class="modal fade" id="modal-manual" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item Manual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_manual" name="form_manual" class="form-horizontal"
                    method="" action="" autocomplete="off">
                    <div class="form-group mb-4">
                        <div class="row">

                            <div class="col-12 col-sm-6">
                                <label>Nombre Producto: </label>
                                <input placeholder="Escribe el nombre y selecciona..." class="form-control" id="nombre_manual" name="nombre_manual" type="text" />
                            </div>

                            <div class="col-12 col-sm-2">
                                <label>Cantidad: </label>
                                <input onkeyup="valida(this)" value="" class="form-control" id="cantidad_manual" name="cantidad_manual" type="number" />
                            </div>

                            <div class="col-12 col-sm-4">
                                <label>Precio: </label>
                                <input onkeyup="valida(this)" value="" class="form-control" id="precio_manual" name="precio_manual" type="number" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id="agrega_manual" disabled type="button" class="btn btn-success btn-ok">Agregar Item</button>
            </div>
        </div>
    </div>
</div>

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
                $("#precio").val(ui.item.precio_venta);
                if ($("#cantidad").val() <= 0) {
                    $("#cantidad").val(1);
                }
                $("#cantidad").select();
                $("#cantidad").focus();

                setTimeout(
                    function() {
                        e = jQuery.Event("keypress");
                        e.wich = 13;
                        agregarProducto($("#id_producto").val(), $("#cantidad").val(), $("#precio").val(), '<?= $idVentaTmp ?>');
                    }
                )
            }
        });
    });



    $(function() {
        $("#nombre").autocomplete({
            source: "<?= base_url() ?>productos/autoCompletebyName/",
            minLength: 3,
            select: function(event, ui) {
                event.preventDefault();
                $("#id_producto").val(ui.item.id);
                $("#codigo").val(ui.item.value);
                $("#nombre").val(ui.item.nombre);
                $("#precio").val(ui.item.precio_venta);
                if ($("#cantidad").val() <= 0) {
                    $("#cantidad").val(1);
                }
                $("#cantidad").select();
                $("#cantidad").focus();

                setTimeout(
                    function() {
                        e = jQuery.Event("keypress");
                        e.wich = 13;
                        agregarProducto($("#id_producto").val(), $("#cantidad").val(), $("#precio").val(), '<?= $idVentaTmp ?>');
                    }
                )
            }
        });
    });




    $(function() {
        $("#nombre_manual").autocomplete({
            source: "<?= base_url() ?>productos/autoCompletebyName/",
            minLength: 3,
            select: function(event, ui) {
                event.preventDefault();
                $("#id_producto").val(ui.item.id);
                $("#codigo").val(ui.item.value);
                $("#nombre_manual").val(ui.item.nombre);
                $("#precio_manual").val(ui.item.precio_venta);
                if ($("#cantidad_manual").val() <= 0) {
                    $("#cantidad_manual").val(1);
                }
                $("#agrega_manual").prop('disabled', false);
                $("#nombre_manual").prop('readonly', true);
                $("#precio_manual").select();
                $("#precio_manual").focus();


            }
        });
    });

    $("#venta_manual").click(function() {
        $("#nombre_manual").val('');
        $("#precio_manual").val('');
        $("#cantidad_manual").val('');
        $("#nombre_manual").select();
        $("#nombre_manual").focus();
        $("#agrega_manual").prop('disabled', true);
        $("#nombre_manual").prop('readonly', false);

    });

    $("#agrega_manual").click(function() {
        agregarProducto($("#id_producto").val(), $("#cantidad_manual").val(), $("#precio_manual").val(), '<?= $idVentaTmp ?>');
        $('#modal-manual').modal('hide');
    });

    $("#anonimo").click(function() {
        if ($("#anonimo").prop('checked') == false) {
            $("#cliente").val("");
            $("#cliente").attr('readonly', false);
            $("#cliente").focus();
        } else {
            $("#cliente").val("Cliente Anónimo");
            $("#cliente").attr('readonly', true);
            $("#id_cliente").val(1);
            $("#codigo").focus();
        }
    });

    function agregarProducto(id_producto, cantidad, precio, id_venta) {
        if (id_producto != null && id_producto != 0 && cantidad > 0) {


            $.ajax({
                url: '<?= base_url() ?>temporalmovimiento/insertar/' + id_producto + '/' + cantidad + '/' + precio + '/' + id_venta + '/' + 'venta',
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
                                agregarProducto($("#id_producto").val(), $("#cantidad").val(), $("#precio").val(), '<?= $idVentaTmp ?>');
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


    function eliminarProducto(id_producto, id_compra, precio) {
        if (id_producto != null && id_producto != 0) {


            $.ajax({
                url: '<?= base_url() ?>temporalmovimiento/eliminar/' + id_producto + '/' + id_compra + '/' + precio,
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
        $("#completa_venta").click(function() {
            let nFila = $("#tablaProductos tr").length;
            if (nFila < 2) {
                $("#text-alerta").html('No se han agregado productos!.');
                $("#modal-alerta").modal('show');
            } else {
                $("#form_venta").submit();
            }
        });
    });
</script>