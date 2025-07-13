
</div>
    <!-- End of Main Content -->

<!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <a target="_blank" href="https://infoclever.cl">Infoclever.cl</a> <?=date('Y')?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro que deseas salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Salir" nuevamente si estás seguro que deseas cerrar sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="<?=base_url()?>usuarios/logout">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url()?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url()?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url()?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?=base_url()?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url()?>js/demo/datatables-demo.js"></script>

<!-- funcionalidad ok button para dialogos de confirmacion -->
 <script>
    $("#modal-confirma").on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
 </script>
</body>

</html>