<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CleverPos - Registro</title>

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

     <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- rut chileno -->
        <script src="js/jquery.rut.js"></script>


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                        <img width="100%" height="100%" src="<?= base_url() ?>img/portada.jpg">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-0">CleverPOS</h1>
                                <p class="text-xs font-italic">by <a target="_blank" href="https://infoclever.cl">Infoclever</a></p>
                                <p class="mb-3">Registrate ahora y accede gratis a tu periodo de prueba</p>
                            </div>
                            <?php
                            if (isset($validation)) { ?>
                                <div class="alert alert-danger text-xs px-0">
                                    <?php echo $validation->listErrors(); ?>
                                </div>
                            <?php }
                            if (isset($mensaje_error)) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $mensaje_error ?>
                                </div>
                            <?php } 
                          
                            if (isset($mensaje_success)) { ?>
                                <div class="alert alert-success">
                                    <?php echo $mensaje_success ?>
                                </div>
                            <?php } 
                            if (isset($mail_enviado)&&($mail_enviado!='OK')) { ?>
                                <div class="alert alert-warning">
                                    <?php echo $mail_enviado ?>
                                </div>
                            <?php } ?>
                     

                            <form class="user" id="formulario-registro" method="POST" action="<?= base_url() ?>registro">
                                  <?=csrf_field()?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input required type="text" class="form-control form-control-user" id="nombre" name="nombre"
                                            placeholder="Nombre" value="<?= set_value('nombre') ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input required type="text" class="form-control form-control-user" id="usuario" name="usuario"
                                            placeholder="Nombre de Usuario (Nickname)" value="<?= set_value('usuario') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" required class="form-control form-control-user" value="<?= set_value('nombre_tienda') ?>" id="nombre_tienda" name="nombre_tienda"
                                            placeholder="Razón Social o Nombre Tienda">
                                    </div>
                                    <div class="col-sm-6 control-group">
                                        <input type="text" required class="form-control form-control-user" id="rut" name="rut"
                                            placeholder="RUT tienda o RUN Persona Natural" value="<?= set_value('rut') ?>">
                                             
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" required class="form-control form-control-user" value="<?= set_value('direccion') ?>" id="direccion" name="direccion"
                                            placeholder="Dirección">
                                    </div>
                                   
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select name="region" id="region" class="form-control">
                                            <option value="">Región</option>
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
                                    <div class="col-sm-6">
                                        <input type="comuna" required class="form-control form-control-user"
                                            id="comuna" name="comuna" placeholder="Comuna" value="<?= set_value('comuna') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="email" required class="form-control form-control-user" id="correo" name="correo"
                                            placeholder="Correo Electrónico" value="<?= set_value('correo') ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="fono" required class="form-control form-control-user"
                                            id="fono" name="fono" placeholder="Teléfono" value="<?= set_value('fono') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" required class="form-control form-control-user"
                                            id="password" name="password" placeholder="Contraseña" value="<?= set_value('password') ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" required class="form-control form-control-user"
                                            id="repassword" name="repassword" placeholder="Repita Contraseña" value="<?= set_value('repassword') ?>">
                                    </div>
                                </div>
                                <button type="button" id="boton-enviar" class="btn btn-primary btn-user btn-block">
                                    Registrarme
                                </button>
                                <hr>

                            </form>
                            <hr>

                            <div class="text-center">
                                <a class="small" href="<?= base_url() ?>/">¿Ya tienes una cuenta? Ingresa Ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

 <div style="position: absolute; top:10%; right:30%;" class="toast  m-2" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <strong class="me-auto">Atención</strong>
    <small></small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body alert alert-danger">
  </div>
</div>

   

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        $("#rut").rut({formatOn: 'keyup', validateOn: 'keyup'})
  .on('rutInvalido', function(){ 
  })
  .on('rutValido', function(){ 
  });


  $("#boton-enviar").click(function(){
    if($("#nombre").val()=='') {
    $(".toast-body").html('El campo Nombre es obligatorio');
    $('.toast').toast('show');
    $("#nombre").select();
    $("#nombre").focus();
    exit;
}

if($("#usuario").val()=='') {
    $(".toast-body").html('El campo Usuario es obligatorio');
    $('.toast').toast('show');
    $("#usuario").select();
    $("#usuario").focus();
    exit;
}

if($("#nombre_tienda").val()=='') {
    $(".toast-body").html('Debe ingresar el nombre de la tienda');
    $('.toast').toast('show');
    $("#nombre_tienda").select();
    $("#nombre_tienda").focus();
    exit;
}
if(!$.validateRut($("#rut").val())) {
    $(".toast-body").html('El rut ingresado no es válido.');
    $('.toast').toast('show');
    $("#rut").select();
    $("#rut").focus();
    exit;
}
if($("#direccion").val()=='') {
    $(".toast-body").html('El campo direccion es obligatorio');
    $('.toast').toast('show');
    $("#direccion").select();
    $("#direccion").focus();
    exit;
}
if($("#region").val()=='') {
    $(".toast-body").html('Debe seleccionar una región');
    $('.toast').toast('show');
    $("#region").select();
    $("#region").focus();
    exit;
}
if($("#comuna").val()=='') {
    $(".toast-body").html('El campo Comuna es obligatorio');
    $('.toast').toast('show');
    $("#comuna").select();
    $("#comuna").focus();
    exit;
}
    if(!validateEmail($("#correo").val())||$("#correo").val()=='') {
    $(".toast-body").html('El formato del email no es correcto');
    $('.toast').toast('show');
    $("#correo").select();
    $("#correo").focus();
    exit;
}
if($("#fono").val()=='') {
    $(".toast-body").html('El campo Teléfono es obligatorio');
    $('.toast').toast('show');
    $("#fono").select();
    $("#fono").focus();
    exit;
}
if($("#password").val()=='' || $("#password").val().length<4) {
    $(".toast-body").html('El campo Contraseña es obligatorio y bebe contener, al menos 4 caracteres');
    $('.toast').toast('show');
    $("#password").select();
    $("#password").focus();
    exit;
}

if($("#repassword").val()!=$("#password").val()) {
    $(".toast-body").html('Las contraseñas deben ser iguales');
    $('.toast').toast('show');
    $("#repassword").select();
    $("#repassword").focus();
    exit;
}

$("#formulario-registro").submit();
});



function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
    </script>

</body>

</html>

