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
        <form method="POST" action="<?=base_url()?>usuarios/actualizar" autocomplete="off">
              <?=csrf_field()?>
             <input type="hidden" id="id" name="id" value="<?= $datos['id'] ?>" ?>
            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Usuario (Nickname): </label>
                        <input required autofocus value="<?=$datos['usuario']?>" class="form-control" id="usuario" name="usuario" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre: </label>
                        <input required class="form-control" value="<?=$datos['nombre']?>" id="nombre" name="nombre" type="text" />
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <input value="0" onclick="habilitaPwd(this);" type="checkbox" name="edit_pwd" id="edit_pwd"/><label>¿Editar Contraseña? </label>
                        <input readonly required value="1234" class="form-control" id="password" name="password" type="password" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Repita contraseña: </label>
                        <input readonly required class="form-control" value="1234" id="repassword" name="repassword" type="password" />
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
                                    <?php if ($caja['id'] == $datos['id_caja']) {
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
                                    <?php if ($rol['id'] == $datos['id_rol']) {
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

<script>
    function habilitaPwd(check){
        if(check.checked){
            check.value=1;
             document.getElementById('password').value = '';
            document.getElementById('repassword').value = '';
            document.getElementById('password').readOnly  = false;
            document.getElementById('repassword').readOnly  = false;
            document.getElementById('password').focus();

        }
        else{
            check.value=0;
            document.getElementById('password').value = '1234';
            document.getElementById('repassword').value = '1234';
            document.getElementById('password').readOnly  = true;
            document.getElementById('repassword').readOnly  = true;
        }
    }
</script>