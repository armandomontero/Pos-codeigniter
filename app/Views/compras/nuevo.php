<?php
$id_compra = uniqid();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card-body">
        <form method="POST" name="form_compra" id="form_compra" action="<?= base_url() ?>compras/guardar" autocomplete="off">
              <?=csrf_field()?>
            <input type="hidden" id="id_producto" name="id_producto" />
             <input type="hidden" value="<?=$id_compra?>" id="id_compra" name="id_compra" />
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
                        <input onkeyup="calcSubTotal(document.getElementById('precio').value, this.value)" value="" class="form-control" id="cantidad" name="cantidad" type="text" />
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <label>Precio Compra: </label>
                        <input onkeyup="calcSubTotal(document.getElementById('cantidad').value, this.value)" class="form-control" id="precio" name="precio" type="text" />
                    </div>
                    <div class="col-12 col-sm-4">
                        <label>Subtotal: </label>
                        <input disabled class="form-control" id="subtotal" name="subtotal" type="text" />
                    </div>

                    <div class="col-12 col-sm-4">
                        <label>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </label>
                        <button onclick="agregarProducto(id_producto.value, cantidad.value, precio.value, '<?= $id_compra ?>')"
                            id="agregar_producto" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Producto</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th width="1%"></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 offset-md-5">
                    <label style="font-weight: bold; font-size: 30px; text-align: center;">Total</label>
                    <input type="text" class="text-center" text id="total" name="total" size="7" readonly="true" value="0"
                        style="font-weight: bold; font-size: 30px; text-align: left;" />
                        <input type="hidden" value="" id="total_numero" name="total_numero"/>
                    <button type="button" id="completa_compra" class="btn btn-success">Completar Compra</button>
                </div>

            </div>


        </form>
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
<!-- invocamos jquery desde acá, ya que si no no carga, la otra opción era afectar todo el template para llamar desde el header -->
<script src="<?= base_url() ?>vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#completa_compra").click(function(){
            let nFila = $("#tablaProductos tr").length;
            if(nFila<2){
                 $("#text-alerta").html('No se han agregado productos!.');
                $("#modal-alerta").modal('show');
            }
            else{
                $("#form_compra").submit();
            }
        });
    });

    function calcSubTotal() {
        var precio = $("#precio").val();
        var cantidad = $("#cantidad").val();

        if (isNaN(precio)) {
            $("#precio").val('0');
            precio = 0;
        }

        if (isNaN(cantidad)) {
            $("#cantidad").val('0');
            cantidad = 0;
        }
        var subtotal = Math.round(precio * cantidad);
        $("#subtotal").val(subtotal);
    }


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
                                $("#cantidad").val(1);
                                $("#precio").val(resultado.datos.precio_compra);
                                $("#subtotal").val(resultado.datos.precio_compra);
                                 $("#cantidad").select();
                                $("#cantidad").focus();
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
    }


    function agregarProducto(id_producto, cantidad, precio,  id_compra) {
        if (id_producto != null && id_producto != 0 && cantidad > 0) {


            $.ajax({
                url: '<?= base_url() ?>temporalmovimiento/insertar/' + id_producto + '/' + cantidad + '/' + precio + '/' + id_compra + '/' + 'compra',
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
    }


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

    }
</script>