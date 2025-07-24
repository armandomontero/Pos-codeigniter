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
<?php }?>

        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/cajas/actualizar" autocomplete="off">
                  <?=csrf_field()?>
                <input type="hidden" id="id" name="id" value="<?=$datos['id']?>"?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label>Número Caja: </label>
                            <input require autofocus class="form-control" value="<?=$datos['numero_caja']?>" id="numero_caja" name="numero_caja" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Nombre: </label>
                            <input require autofocus class="form-control" value="<?=$datos['nombre']?>" id="nombre" name="nombre" type="text" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>Folio: </label>
                            <input require autofocus class="form-control" value="<?=$datos['folio']?>" id="folio" name="folio" type="number" />
                        </div>
                    </div>
                </div>

                <a href="<?= base_url() ?>cajas" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>