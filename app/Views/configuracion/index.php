<?php
?>


<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <!-- Page Heading -->

<ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>

        


    </div>
    <!-- /.container-fluid -->


    <!-- End of Main Content -->
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
