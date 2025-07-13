<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Infoclever - POS | Login</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/vnd.icon" href="<?= base_url() ?>favicon.ico" />
    <link href="<?= base_url() ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>css/sb-admin-2.min.css" rel="stylesheet" />
    <!-- Custom styles for this page -->
    <link href="<?= base_url() ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <?php
                        if (isset($validation)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $validation->listErrors(); ?>
                            </div>
                        <?php } ?>
    <?php
                        if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $error ?>
                            </div>
                        <?php } ?>
                        
                        <div class="row">

                            <div class="col-lg-6 d-none d-lg-block bg-login-image ">
                                <img width="420" src="<?=base_url()?>img/portada.jpg">
                            </div>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistema POS | Infoclever</h1>
                                        <p>Bienvenido</p>
                                    </div>
                                    <form class="user" method="POST" action="<?= base_url() ?>usuarios/valida">
                                        <div class="form-group">
                                            <label>Usuario: </label>
                                            <input type="text" name="usuario" value="<?=set_value('usuario')?>" id="usuario" class="form-control form-control-user"
                                                aria-describedby="emailHelp"
                                                placeholder="Ingresa tu usuario...">
                                        </div>
                                        <div class="form-group">
                                            <label>Contraseña:</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="password" value="<?=set_value('password')?>" name="password" placeholder="Contraseña">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <!--<input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Recordarme</label>-->
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Iniciar Sesión
                                        </button>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">¿Olvidaste tu contraseña?</a>
                                    </div>
                                    <div class="text-center">
                                        <!--<a class="small" href="register.html">Create an Account!</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; <a target="_blank" href="https://infoclever.cl">Infoclever.cl</a> <?= date('Y') ?></span>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>js/sb-admin-2.min.js"></script>

</body>

</html>