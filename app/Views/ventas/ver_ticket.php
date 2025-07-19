<main>
    <div class="container-fluid ">
       <div class="col-lg-4 col-md-4 col-sm-4 container  justify-content-center">
       
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="panel">
                    <div class="embed-responsive  embed-responsive-4by3 mt-20">

                        <iframe class="embed-responsive-item " src="<?= base_url() ?>ventas/generaTicket/<?= $id_venta ?>"></iframe>

                    </div>
                </div>
            </div>
        </div>

        <div class="row container  justify-content-center mb-4">
        <Button onclick="window.location.reload();" class="btn btn-success"><i class="fas fa-print"></i> Imprimir Nuevamente</Button>
       
    </div>
    <div class="row container  justify-content-center">
      <a href="<?=base_url()?>ventas/venta" id="nueva" class="btn btn-primary"><i class="fas fa-cash-register"></i> Nueva Venta</a></div>
    </div>
</main>

<script>
setTimeout(() => {
$("#nueva").select();
$("#nueva").focus();
}, "1 second");
</script>