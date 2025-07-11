<?php
?>
 <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?=$titulo?></h1>

<?php echo \Config\Services::validation()->listErrors();?>

        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/unidades/insertar" autocomplete="off">
                <?php csrf_field();?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input  required autofocus class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Nombre Corto: </label>
                            <input   class="form-control" id="nombre_corto" name="nombre_corto" type="text" />
                        </div>
                    </div>
                </div>

                <a href="<?= base_url() ?>unidades" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
    </div>
