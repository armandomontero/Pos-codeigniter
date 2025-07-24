<?php
?>
<main>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
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
            <form method="POST" enctype="multipart/form-data" action="<?= base_url() ?>configuracion/actualizar" autocomplete="off">
                  <?=csrf_field()?>
                <input type="hidden" id="id" name="id" value="<?= $datos['id'] ?>" ?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input require autofocus class="form-control" value="<?= $datos['nombre'] ?>" id="nombre" name="nombre" type="text" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Dirección: </label>
                            <input require class="form-control" value="<?= $datos['direccion'] ?>" id="direccion" name="direccion" type="text" />
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Mensaje: </label>
                            <input require autofocus class="form-control" value="<?= $datos['mensaje'] ?>" id="mensaje" name="mensaje" type="text" />
                        </div>
                        <div class="col-12 col-sm-6">

                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <div class="row">

                        <div class="col-12 col-sm-6">
                            <label>Logotipo</label>
                            <img src="<?= base_url() . $datos['logo'] ?>" class="img-responsive" width="200" />
                            <input  type="file" class="form-control" id="tienda_logo" name="tienda_logo" accept="image/jpeg, image/png" />
                        </div>
                    </div>
                </div>

                <a href="<?= base_url() ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>

