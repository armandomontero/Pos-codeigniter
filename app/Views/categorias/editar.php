<?php
?>
<main>
    <div class="container-fluid px-4">
        
        <h1 class="mt-4"><?= $titulo ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>



        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/categorias/actualizar" autocomplete="off">
                <input type="hidden" id="id" name="id" value="<?=$datos['id']?>"?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input require autofocus class="form-control" value="<?=$datos['nombre']?>" id="nombre" name="nombre" type="text" />
                        </div>
                        
                    </div>
                </div>

                <a href="<?= base_url() ?>categorias" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>

            </form>
        </div>
    </div>
    </div>
</main>