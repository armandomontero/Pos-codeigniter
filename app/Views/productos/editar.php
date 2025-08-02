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
<div class="alert alert-success">
<?php echo $mensaje;?>
</div>
<?php }?>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="<?= base_url() ?>/productos/actualizar" autocomplete="off">
                  <?=csrf_field()?>
                <input type="hidden" id="id" name="id" value="<?=$datos['id']?>"?>
                 <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Código: </label>
                    <input required autofocus class="form-control" value="<?=$datos['codigo']?>" id="codigo" name="codigo" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Nombre: </label>
                        <input required class="form-control" value="<?=$datos['nombre']?>" id="nombre" name="nombre" type="text" />
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
                                <?php if($unidad['id']==$datos['id_unidad']) echo 'selected'; ?>
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
                                <?php if($categoria['id']==$datos['id_categoria']) echo 'selected'; ?>
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
                        <input required autofocus class="form-control" value="<?=$datos['precio_venta']?>" id="precio_venta" name="precio_venta" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Precio Compra: </label>
                        <input required class="form-control" id="precio_compra" value="<?=$datos['precio_compra']?>" name="precio_compra" type="text" />
                    </div>
                </div>
            </div>

             <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Stock Mínimo: </label>
                        <input required autofocus class="form-control" value="<?=$datos['stock_minimo']?>" id="stock_minimo" name="stock_minimo" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Es inventariable?: </label>
                        <select class="form-control" name="inventariable" id="inventariable">
                            <option
                            <?php if($datos['inventariable']==1) echo 'selected'; ?>
                            value="1">Si</option>
                            <option
                             <?php if($datos['inventariable']==0) echo 'selected'; ?>
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
                       <img src="<?= base_url() . $datos['imagen'] ?>" class="img-responsive" width="200" />
                    </div>
                </div>
            </div>

                <a href="<?= base_url() ?>productos" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>