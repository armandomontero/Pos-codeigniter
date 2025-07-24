<?php
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?= $titulo ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>
<?php 
if(isset($validation)){?>
<div class="alert alert-danger">
<?php echo $validation->listErrors();?>
</div>
<?php }

if(isset($mensaje)){?>
<div class="alert alert-success">
<?php echo $mensaje;?>
</div>
<?php }?>

        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/usuarios/actualizar_password" autocomplete="off">
                  <?=csrf_field()?>
                <input type="hidden" name="id" id="id" value="<?=$usuario['id']?>"/>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Usuario: </label>
                            <input disabled value="<?=$usuario['usuario']?>" class="form-control" id="usuario" name="usuario" type="text" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input  disabled  value="<?=$usuario['nombre']?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                        
                    </div>
                </div>

                 <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nueva contraseña: </label>
                            <input required autofocus value="" class="form-control" id="password" name="password" type="password" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Repita contraseña: </label>
                            <input required  value="" class="form-control" id="repassword" name="repassword" type="password" />
                        </div>
                        
                    </div>
                </div>
                <a href="<?= base_url() ?>categorias" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>