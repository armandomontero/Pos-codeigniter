<?php
?>
<!-- Begin Page Content -->
<main>
    <div class="container-fluid">
        <!-- Page Heading -->
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>


<div>
    <form method="POST" action="<?=base_url()?>roles/guardaPermisos">
          <?=csrf_field()?>
        <input type="hidden" value="<?=$id_rol?>" name="id_rol"/>
        <div class="form-group">
            <?php foreach($permisos as $row) {?>
                <div class="form-check">
            <input <?php if($row['checked']==true) echo 'checked' ?> class="form-check-input" type="checkbox" name="permisos[<?=$row['id']?>]" value="<?=$row['id']?> id="<?=$row['id']?>"/> <label class="form-check-label" for="<?=$row['id']?>"> <?php echo $row['nombre']; ?></label>
                </div>
            <?php } ?>
        </div>
        
                <a href="<?= base_url() ?>roles" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>
</div>

    </div>
</main>