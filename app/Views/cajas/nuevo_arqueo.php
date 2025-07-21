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

<?php 
if(isset($mensaje)){?>
<div class="alert alert-warning">
<?php echo $mensaje;?>
</div>
<?php }?>


        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/cajas/nuevo_arqueo" autocomplete="off">
                <input type="hidden" id="redireccion" name="redireccion" value="<?php if(isset($redirige)){echo $redirige;} else{echo 'cajas';} ?>                "/>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Número Caja: </label>
                            <input  readonly  placeholder="Ej. Caja 4"
                             value="<?=$datos['numero_caja']?>" class="form-control" id="numero_caja" name="numero_caja" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Nombre: </label>
                            <input  readonly value="<?=$datos['nombre']?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                    
                    </div>
                </div>

                  <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Monto Inical: </label>
                            <input autofocus placeholder="Ej. $30.000"
                             value="" class="form-control" id="monto_inicial" name="monto_inicial" type="number" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Monto Final: </label>
                            <input  readonly value="" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                    
                    </div>
                </div>
                                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Fecha: </label>
                            <input  readonly  placeholder="Ej. Caja 4"
                             value="<?=date('d-m-Y')?>" class="form-control" id="numero_caja" name="numero_caja" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Hora: </label>
                            <input  readonly value="<?=date('H:i:s')?>" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                    
                    </div>
                </div>
                <a href="<?= base_url() ?>cajas/arqueos/<?=$datos['id']?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>