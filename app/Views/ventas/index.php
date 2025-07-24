<?php
helper('number');
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
            <a class="btn btn-warning" href="<?= base_url() ?>ventas/eliminados">Eliminados</a>
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
                            <tr class="bg-primary text-white">
                                <th>ID</th>
                                <th>Folio</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Cajero</th>
                                <th>Cliente</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>ID</th>
                                <th>Folio</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Cajero</th>
                                <th>Cliente</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($datos as $dato) {

                            ?>
                                <tr>
                                    <td class="text-right"><?php echo $dato['id']; ?></td>
                                    <td class="text-right"><?php echo $dato['folio']; ?></td>
                                    <td class="text-right"><?php echo number_to_currency($dato['total'], 'USD', 'en_US', 0); ?></td>
                                    <td class="text-center"><?php echo  date('d-m-Y H:i:s', strtotime($dato['created_at'])); ?></td>
                                    <td><?php echo $dato['cajero']; ?></td>
                                    <td><?php echo $dato['cliente']; ?></td>
                                    <td><a class="btn btn-primary btn-sm" target="_blank" href="<?= base_url() ?>ventas/muestraTicket/<?php echo $dato['id']; ?>"><i class="fas fa-print"></i></a></td>
                                    <td><a data-toggle="modal" data-target="#modal-confirma" class="btn btn-danger btn-sm" href="#" data-href="<?= base_url() ?>ventas/eliminar/<?php echo $dato['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>

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