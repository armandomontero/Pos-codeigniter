<main>
    <div class="container-fluid px-4 covered">
        <div class="covered-img"></div>
        <div class="bg-light text-dark text-center p-3 bg-opacity-50 covered">
            <h3>Infoclever | POS</h3>
            <p>Bienvenido/a</p>
        </div>

        <div class="row mt-3">
            <div class="col-lg-4 col-md-2 mb-2">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                         Productos en total: <?=$total_productos?>
                    </div>
                    <a class="card-footer " href="<?=base_url()?>productos">Ver Detalle</a>
                </div >
            </div>

            <div class="col-lg-4 col-md-2 mb-2">
                <div class="card bg-success text-white">
                    <div class="card-body">
                         Se han vendido $<?=number_format($total_dia, 0, ',', '.')?> en <?=$ventas_dia?> ventas
                    </div>
                    <a class="card-footer" href="<?=base_url()?>ventas">Ver Detalle</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-2 mb-2">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <?=$productos_minimo?> productos bajo su stock mínimo
                    </div>
                    <a class="card-footer" href="<?=base_url()?>productos/reporteMinimos">Ver Detalle</a>
                </div>
            </div>
        </div>
    </div>
</main>