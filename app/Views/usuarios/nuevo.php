<?php
?>
<main>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active"><?= $titulo ?></li>
    </ol>
    <?php
    if (isset($validation)) { ?>
        <div class="alert alert-danger">
            <?php echo $validation->listErrors(); ?>
        </div>
    <?php } ?>

    <div class="card-body">
        <form method="POST" action="<?= base_url() ?>/usuarios/insertar" autocomplete="off">
            <?php csrf_field(); ?>
            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Usuario (Nickname): </label>
                        <input required autofocus value="<?= set_value('usuario') ?>" class="form-control" id="usuario" name="usuario" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre: </label>
                        <input required class="form-control" value="<?= set_value('nombre') ?>" id="nombre" name="nombre" type="text" />
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Contraseña: </label>
                        <input required value="<?= set_value('password') ?>" class="form-control" id="password" name="password" type="password" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Repita contraseña: </label>
                        <input required class="form-control" value="<?= set_value('repassword') ?>" id="repassword" name="repassword" type="password" />
                    </div>
                </div>
            </div>


            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Caja: </label>
                        <select class="form-control" name="id_caja" id="id_caja" required>
                            <option value="">Selecciona Caja</option>
                            <?php foreach ($cajas as $caja) { ?>
                                <option
                                    <?php if ($caja['id'] == set_value('id_caja')) {
                                        echo 'selected';
                                    } ?>
                                    value="<?= $caja['id'] ?>"><?= $caja['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Rol: </label>
                        <select class="form-control" name="id_rol" id="id_rol" required>
                            <option value="">Selecciona Rol</option>
                            <?php foreach ($roles as $rol) { ?>
                                <option
                                    <?php if ($rol['id'] == set_value('id_rol')) {
                                        echo 'selected';
                                    } ?>
                                    value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
            </div>
            <a href="<?= base_url() ?>usuarios" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

        </form>
    </div>
</div>
</main>