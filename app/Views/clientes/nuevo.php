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

        <form method="POST" action="<?= base_url() ?>/clientes/insertar" autocomplete="off">
              <?=csrf_field()?>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre: </label>
                        <input required autofocus value="<?=set_value('nombre')?>" class="form-control" id="nombre" name="nombre" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>Dirección: </label>
                        <input required class="form-control" value="<?=set_value('direccion')?>" id="direccion" name="direccion" type="text" />
                    </div>
                </div>
            </div>
            <div class="form-group mb-4 mt-4">
                <div class="row ">
                    <div class="col-12 col-sm-6">
                        <label>Región: </label>
                        <select required class="form-control" name="region" id="region" required>
                            <option value="">Selecciona</option>
                           <option <?php if(set_value('region')=='Región de Arica y Parinacota'){echo 'selected';} ?> 
                            value="Región de Arica y Parinacota">Región de Arica y Parinacota</option>
                           <option <?php if(set_value('region')=='Región de Tarapacá'){echo 'selected';} ?> 
                            value="Región de Tarapacá">Región de Tarapacá</option>
                           <option <?php if(set_value('region')=='Región de Antofagasta'){echo 'selected';} ?> 
                            value="Región de Antofagasta">Región de Antofagasta</option>
                           <option <?php if(set_value('region')=='Región de Atacama'){echo 'selected';} ?> 
                            value="Región de Atacama">Región de Atacama</option>
                           <option <?php if(set_value('region')=='Región de Coquimbo'){echo 'selected';} ?> 
                             value="Región de Coquimbo">Región de Coquimbo</option>
                           <option <?php if(set_value('region')=='Región de Valparaíso'){echo 'selected';} ?> 
                             value="Región de Valparaíso">Región de Valparaíso</option>
                           <option <?php if(set_value('region')=='Región Metropolitana de Santiago'){echo 'selected';} ?> 
                            value="Región Metropolitana de Santiago">Región Metropolitana de Santiago</option>
                           <option <?php if(set_value('region')=="Región del Libertador General Bernardo O'Higgins"){echo 'selected';} ?> 
                            value="Región del Libertador General Bernardo O'Higgins">Región del Libertador General Bernardo O'Higgins</option>
                           <option <?php if(set_value('region')=='Región del Maule'){echo 'selected';} ?> 
                            value="Región del Maule">Región del Maule</option>
                           <option <?php if(set_value('region')=='Región de Ñuble'){echo 'selected';} ?> 
                            value="Región de Ñuble">Región de Ñuble</option>
                           <option <?php if(set_value('region')=='Región del Biobío'){echo 'selected';} ?> 
                            value="Región del Biobío">Región del Biobío</option>
                           <option <?php if(set_value('region')=='Región de la Araucanía'){echo 'selected';} ?> 
                            value="Región de la Araucanía">Región de la Araucanía</option>
                           <option <?php if(set_value('region')=='Región de Los Ríos'){echo 'selected';} ?> 
                            value="Región de Los Ríos">Región de Los Ríos</option>
                           <option <?php if(set_value('region')=='Región de Los Lagos'){echo 'selected';} ?> 
                            value="Región de Los Lagos">Región de Los Lagos</option>
                           <option <?php if(set_value('region')=='Región de Aysén del General Carlos Ibáñez del Campo'){echo 'selected';} ?> 
                            value="Región de Aysén del General Carlos Ibáñez del Campo">Región de Aysén del General Carlos Ibáñez del Campo</option>
                           <option <?php if(set_value('region')=='Región de Magallanes y de la Antártica Chilena'){echo 'selected';} ?> 
                            value="Región de Magallanes y de la Antártica Chilena">Región de Magallanes y de la Antártica Chilena</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                         <label>Comuna: </label>
                        <input required class="form-control" value="<?=set_value('comuna')?>" id="comuna" name="comuna" type="text" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Teléfono: </label>
                        <input required autofocus value="<?=set_value('telefono')?>" class="form-control" id="telefono" name="telefono" type="text" />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label>E-Mail: </label>
                        <input  class="form-control" value="<?=set_value('correo')?>" id="correo" name="correo" type="email" />
                    </div>
                </div>
            </div>



            <div class="d-flex gap-3 justify-content-center align-items-center">
            <a href="<?= base_url() ?>clientes" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Volver</a>
            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>
              </div>
        </form>
    </div>
</main>