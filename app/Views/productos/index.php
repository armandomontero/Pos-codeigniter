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
            <a class="btn btn-info" href="<?= base_url() ?>productos/nuevo">Agregar</a>
            <a class="btn btn-warning" href="<?= base_url() ?>productos/eliminados">Eliminados</a>

        </p>

<?php 
if(isset($mensaje)){?>
<div class="alert alert-success">
<?php echo $mensaje;?>
</div>
<?php }?>

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
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Existencias</th>
                                 <th>Imagen</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Existencias</th>
                                 <th>Imagen</th>
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
                                    <td class="text-right"><a target="_blank" href="<?= base_url() ?>/productos/generaBarras/<?php echo $dato['id']; ?>"><?php echo $dato['codigo']; ?></a></td>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td class="text-right"><?php echo number_to_currency($dato['precio_venta'], 'USD', 'en_US', 0); ?></td>
                                    <td class="text-right"><?php echo number_format($dato['existencias'], 0, ',', '.'); ?></td>
                                    <td class="text-center"><?php if($dato['imagen']){echo '<img width="60px" height="60px" src="'.$dato['imagen'].'"/>';} else{ echo '<i class="fas lg fa-image"></i>';} ?></td>
                                    <td><a class="btn btn-warning btn-sm" href="<?= base_url() ?>productos/editar/<?php echo $dato['id']; ?>"><i class="fas fa-edit"></i></a></td>
                                    <td><a data-toggle="modal" data-target="#modal-confirma" class="btn btn-danger btn-sm" href="#" data-href="<?= base_url() ?>productos/eliminar/<?php echo $dato['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>

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