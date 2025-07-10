<?php
?>
<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?=$titulo?></h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?=base_url()?>">Inicio</a></li>
                <li class="breadcrumb-item active"><?=$titulo?></li>
            </ol>

            <div>
                <p>
                    <a class="btn btn-info" href="<?=base_url()?>unidades/nuevo">Agregar</a>
                    <a class="btn btn-warning" href="<?=base_url()?>unidades/eliminados">Eliminados</a>
                </p>
            </div>
           
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Nombre Corto</th>
                                <th></th>
                                <th></th>
                                
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Nombre Corto</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                            foreach($datos as $dato){
                               
                            ?>
                            <tr>
                                <td><?php echo $dato['id'];?></td>
                                <td><?php echo $dato['nombre'];?></td>
                                <td><?php echo $dato['nombre_corto'];?></td>
                                <td><a class="btn btn-warning" href="<?=base_url()?>unidades/editar/<?php echo $dato['id'];?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td><a class="btn btn-danger" href="<?=base_url()?>unidades/del/<?php echo $dato['id'];?>"><i class="fa-solid fa-trash"></i></a></td>
                              
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    