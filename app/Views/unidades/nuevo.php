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
            <form method="POST" action="<?= base_url() ?>/unidades/insertar" autocomplete="off">
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input require autofocus class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Nombre Corto: </label>
                            <input require class="form-control" id="nombre_corto" name="nombre_corto" type="text" />
                        </div>
                    </div>
                </div>

                <a href="<?= base_url() ?>unidades" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>

            </form>
        </div>
    </div>
    </div>
</main>