<?php
?>
<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <!-- Page Heading -->
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>
        <p>
            <a class="btn btn-info" href="<?= base_url() ?>cajas/nuevo_arqueo">Agregar</a>
        </p>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-xs bg-primary text-white">
                                <th>ID</th>
                                <th>Fecha Apertura</th>
                                <th>Fecha Cierre</th>
                                <th>Monto Inicial</th>
                                <th>Monto Final</th>
                                <th>T. Efectivo</th>
                                 <th>Diferencia</th>
                                 <th>T. Crédito/Débito</th>
                                 <th>T. Transferencia</th>
                                <th>Total Ventas</th>
                                <th>Status</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tfoot >
                            <tr class="text-xs bg-primary text-white">
                          <th>ID</th>
                             <th>Fecha Apertura</th>
                                <th>Fecha Cierre</th>
                                <th>Monto Inicial</th>
                                <th>Monto Final</th>
                                <th>T. Efectivo</th>
                                 <th>Diferencia</th>
                                 <th>T. Crédito/Débito</th>
                                 <th>T. Transferencia</th>
                                <th>Total Ventas</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($datos as $dato) {

                            ?>
                                <tr>
                                    <td class="text-right"><?php echo $dato['id']; ?></td>
                                    <td class="text-xs"><?php echo date('d-m-Y H:i:s', strtotime($dato['fecha_inicio'])); ?></td>
                                    <td class="text-xs"><?php if($dato['fecha_fin']!=null) { echo date('d-m-Y H:i:s', strtotime($dato['fecha_fin'])); } ?></td>
                                    <td class="text-right">$<?php echo number_format($dato['monto_inicial'], 0, ',', '.'); ?></td>
                                    <td class="text-right">$<?php echo number_format($dato['monto_final'], 0, ',', '.'); ?></td>
                                    <td class="text-right">$<?php echo number_format($dato['total_efectivo'], 0, ',', '.'); ?></td>
                                    <td class="text-right 
                                    <?php if($dato['diferencia']<0){echo  'text-danger';}else{  echo 'text-success';}  ?>">
                                    $<?php echo number_format($dato['diferencia'], 0, ',', '.'); ?></td>
                                    <td class="text-right">$<?php echo number_format($dato['total_tarjeta'], 0, ',', '.'); ?></td>
                                    <td class="text-right">$<?php echo number_format($dato['total_transferencia'], 0, ',', '.'); ?></td>
                                    <td class="text-right">$<?php echo number_format($dato['total_ventas'], 0, ',', '.'); ?></td>
                                    <td><?php if($dato['status']==1) {echo 'Abierta'; ?></td>
                                    <td><a class="btn btn-danger btn-sm" href="<?= base_url() ?>cajas/cerrar"><i class="fas fa-lock"></i></a></td>
                                    <?php } else{echo 'Cerrada'; ?></td>
                                    <td><a  class="btn btn-success btn-sm" href="#" data-href="<?= base_url() ?>cajas/eliminar/<?php echo $dato['id']; ?>"><i class="fas fa-file-alt"></i></a></td>
                                        <?php } ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal confirmación -->
<div class="modal fade" id="modal-confirma" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar el registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a type="button" class="btn btn-danger btn-ok">Eliminar</a>
            </div>
        </div>
    </div>
</div>