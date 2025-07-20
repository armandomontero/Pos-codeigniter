<?php
?>
<main>
    <div class="container-fluid px-4">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>
        <?php
        if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>


        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/cajas/cerrar" autocomplete="off">
                <input type="hidden" id="id_arqueo" name="id_arqueo" value="<?=$arqueo['id']?>"/>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Número Caja: </label>
                            <input readonly placeholder="Ej. Caja 4"
                                value="<?= $datos['numero_caja'] ?>" class="form-control text-right" id="numero_caja" name="numero_caja" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Nombre: </label>
                            <input readonly value="<?= $datos['nombre'] ?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>

                    </div>
                </div>

                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Monto Inical ($): </label>
                            <input readonly
                                value="<?= $arqueo['monto_inicial'] ?>" class="form-control text-right" id="monto_inicial" name="monto_inicial" type="number" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Monto Final ($): </label>
                            <input onkeyup="calcula_diferencia();" autofocus placeholder="Ej. 30000" value="" class="form-control text-right" id="monto_final" name="monto_final" type="number" />
                        </div>

                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Fecha: </label>
                            <input readonly placeholder="Ej. Caja 4"
                                value="<?= date('d-m-Y') ?>" class="form-control text-right" id="numero_caja" name="numero_caja" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Hora: </label>
                            <input readonly value="<?= date('H:i:s') ?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>

                    </div>
                </div>


                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Total Ventas Efectivo ($): </label>
                            <input readonly value="<?=$montoTotalEfectivo?>" class="form-control text-right" id="total_efectivo" name="total_efectivo" type="number" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Diferencia ($): </label>
                            <input readonly value="<?=-$montoTotalEfectivo-$arqueo['monto_inicial']?>" class="form-control text-right text-danger" id="diferencia" name="diferencia" type="number" />
                        </div>

                    </div>
                </div>

                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Total Crédito/Débito ($): </label>
                            <input readonly value="<?=$montoTotalTarjeta?>" class="form-control text-right" id="total_tarjeta" name="total_tarjeta" type="number" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Total Transferencias ($): </label>
                            <input readonly value="<?=$montoTransferencia?>" class="form-control text-right" id="total_transferencia" name="total_transferencia" type="number" />
                        </div>

                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Total Ventas (Todos los medios de pago) ($): </label>
                            <input readonly value="<?=$montoTransferencia+$montoTotalEfectivo+$montoTotalTarjeta?>" class="form-control text-right" id="total_total" name="total_total" type="number" />
                        </div>

                    </div>
                </div>
                <a href="<?= base_url() ?>cajas/arqueos/<?= $datos['id'] ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>

<script>
    function calcula_diferencia(){
        let ventasEfectivo = parseInt(document.getElementById('total_efectivo').value);
        let montoInicial = parseInt(document.getElementById('monto_inicial').value);
        let montoFinal = parseInt(document.getElementById('monto_final').value);
        let diferencia = montoFinal-ventasEfectivo-montoInicial;
        document.getElementById('diferencia').value = diferencia;

        if(diferencia<0){
            document.getElementById('diferencia').className = 'form-control text-right text-danger';
        }
        else{
            document.getElementById('diferencia').className = 'form-control text-right text-success';
        }
    }
</script>