<?php
?>
<main>
    <div class="container-fluid px-4">
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
            <form method="POST" action="<?= base_url() ?>/categorias/insertar" autocomplete="off">
                  <?=csrf_field()?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input  required autofocus  value="<?=set_value('nombre')?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                        
                    </div>
                </div>

                <a href="<?= base_url() ?>categorias" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>