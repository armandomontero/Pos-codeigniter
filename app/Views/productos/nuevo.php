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

        <form method="POST" enctype="multipart/form-data" action="<?= base_url() ?>productos/insertar" autocomplete="off">
              <?=csrf_field()?>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Código: </label>
                        <input required autofocus value="<?=set_value('codigo')?>" class="form-control" id="codigo" name="codigo" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre: </label>
                        <input required class="form-control" value="<?=set_value('nombre')?>" id="nombre" name="nombre" type="text" />
                    </div>
                </div>
            </div>
            <div class="form-group mb-4 mt-4">
                <div class="row ">
                    <div class="col-12 col-sm-6">
                        <label>Unidad: </label>
                        <select class="form-control" name="id_unidad" id="id_unidad" required>
                            <option>Selecciona</option>
                            <?php foreach ($unidades as $unidad) { ?>
                                <option
                                <?php if($unidad['id']==set_value('id_unidad')){echo 'selected';} ?>
                                value="<?= $unidad['id'] ?>"><?= $unidad['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Categoría: </label>
                        <select class="form-control" name="id_categoria" id="id_categoria" required>
                            <option>Selecciona</option>
                            <?php foreach ($categorias as $categoria) { ?>
                                <option
                                <?php if($categoria['id']==set_value('id_categoria')){echo 'selected';} ?>
                                value="<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Precio Venta: </label>
                        <input required autofocus value="<?=set_value('precio_venta')?>" class="form-control" id="precio_venta" name="precio_venta" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Precio Compra: </label>
                        <input required class="form-control" value="<?=set_value('precio_compra')?>" id="precio_compra" name="precio_compra" type="text" />
                    </div>
                </div>
            </div>

             <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Stock Mínimo: </label>
                        <input required autofocus value="<?=set_value('stock_minimo')?>" class="form-control" id="stock_minimo" name="stock_minimo" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Es inventariable?: </label>
                        <select class="form-control" name="inventariable" id="inventariable">
                            <option
                            <?php if(1==set_value('inventariable')){echo 'selected';} ?>
                            value="1">Si</option>
                            <option
                             <?php if(0==set_value('inventariable')){echo 'selected';} ?>
                            value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                       <label>Imagen:</label>
                            
                            <input  type="file" class="form-control" id="imagen" name="imagen" accept="image/jpeg, image/png" />
                    </div>
                    <div class="col-12 col-sm-6">
                       
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 justify-content-center align-items-center">
            <a href="<?= base_url() ?>productos" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Volver</a>
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>
              </div>
        </form>
    </div>
</main>