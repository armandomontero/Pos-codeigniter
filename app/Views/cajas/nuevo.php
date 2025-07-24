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
            <form method="POST" action="<?= base_url() ?>/cajas/insertar" autocomplete="off">
                  <?=csrf_field()?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label>Número Caja: </label>
                            <input  required autofocus placeholder="Ej. Caja 4"
                             value="<?=set_value('numero_caja')?>" class="form-control" id="numero_caja" name="numero_caja" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Nombre: </label>
                            <input  required value="<?=set_value('nombre')?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>Folio: </label>
                            <input  required value="<?=set_value('folio')?>" class="form-control" id="folio" name="folio" type="number" />
                        </div>
                    </div>
                </div>

                <a href="<?= base_url() ?>cajas" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>