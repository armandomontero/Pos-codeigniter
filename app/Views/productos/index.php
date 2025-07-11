<?php
?>
<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>
        <p>
            <a class="btn btn-info" href="<?= base_url() ?>productos/nuevo">Agregar</a>
            <a class="btn btn-warning" href="<?= base_url() ?>productos/eliminados">Eliminados</a>
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
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($datos as $dato) {

                            ?>
                                <tr>
                                    <td><?php echo $dato['id']; ?></td>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td><a class="btn btn-warning" href="<?= base_url() ?>productos/editar/<?php echo $dato['id']; ?>"><i class="fas fa-edit"></i></a></td>
                                    <td><a class="btn btn-danger" href="<?= base_url() ?>productos/eliminar/<?php echo $dato['id']; ?>"><i class="fas fa-trash-alt"></a></td>

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