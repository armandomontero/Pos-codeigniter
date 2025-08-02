<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //Home no logeado
$routes->get('/', 'Usuarios::login');
$routes->get('/registro', 'Usuarios::registro');
$routes->post('/registro', 'Usuarios::registro');

 //Home logeado
$routes->get('/index', 'Home::index');

//Unidades
$routes->get('/unidades', 'Unidades::index');
$routes->get('/unidades/eliminados', 'Unidades::eliminados');
$routes->get('/unidades/nuevo', 'Unidades::nuevo');
$routes->post('/unidades/insertar', 'Unidades::insertar');
$routes->get('/unidades/editar/(:num)', 'Unidades::editar/$1');
$routes->post('/unidades/actualizar', 'Unidades::actualizar');
$routes->get('/unidades/eliminar/(:num)', 'Unidades::eliminar/$1');
$routes->get('/unidades/reingresar/(:num)', 'Unidades::reingresar/$1');

//Categorias
$routes->get('/categorias', 'Categorias::index');
$routes->get('/categorias/eliminados', 'Categorias::eliminados');
$routes->get('/categorias/nuevo', 'Categorias::nuevo');
$routes->post('/categorias/insertar', 'Categorias::insertar');
$routes->get('/categorias/editar/(:num)', 'Categorias::editar/$1');
$routes->post('/categorias/actualizar', 'Categorias::actualizar');
$routes->get('/categorias/eliminar/(:num)', 'Categorias::eliminar/$1');
$routes->get('/categorias/reingresar/(:num)', 'Categorias::reingresar/$1');

//Productos
$routes->get('/productos', 'Productos::index');
$routes->get('/productos/eliminados', 'Productos::eliminados');
$routes->get('/productos/nuevo', 'Productos::nuevo');
$routes->post('/productos/insertar', 'Productos::insertar');
$routes->get('/productos/editar/(:num)', 'Productos::editar/$1');
$routes->post('/productos/actualizar', 'Productos::actualizar');
$routes->get('/productos/eliminar/(:num)', 'Productos::eliminar/$1');
$routes->get('/productos/reingresar/(:num)', 'Productos::reingresar/$1');
$routes->get('/productos/buscarPorCodigo/(:any)', 'Productos::buscarPorCodigo/$1');
$routes->get('/productos/autoCompleteData(:any)', 'Productos::autoCompleteData/$1');
$routes->get('/productos/autoCompletebyName(:any)', 'Productos::autoCompletebyName/$1');
$routes->get('/productos/generaBarras/(:num)', 'Productos::generaBarras/$1');
$routes->get('/productos/reporteMinimos', 'Productos::reporteMinimos');
$routes->get('/productos/generaReporteMinimo', 'Productos::generaReporteMinimo');




//Clientes
$routes->get('/clientes', 'Clientes::index');
$routes->get('/clientes/eliminados', 'Clientes::eliminados');
$routes->get('/clientes/nuevo', 'Clientes::nuevo');
$routes->post('/clientes/insertar', 'Clientes::insertar');
$routes->get('/clientes/editar/(:num)', 'Clientes::editar/$1');
$routes->post('/clientes/actualizar', 'Clientes::actualizar');
$routes->get('/clientes/eliminar/(:num)', 'Clientes::eliminar/$1');
$routes->get('/clientes/reingresar/(:num)', 'Clientes::reingresar/$1');
$routes->get('/clientes/autoCompleteData(:any)', 'Clientes::autoCompleteData/$1');



//Configuracion
$routes->get('/configuracion', 'Configuracion::index');
$routes->post('/configuracion/actualizar', 'Configuracion::actualizar');
$routes->get('/configuracion/getLogo', 'Configuracion::getLogo');


//Usuarios
$routes->get('/usuarios', 'Usuarios::index');
$routes->get('/usuarios/eliminados', 'Usuarios::eliminados');
$routes->get('/usuarios/nuevo', 'Usuarios::nuevo');
$routes->post('/usuarios/insertar', 'Usuarios::insertar');
$routes->get('/usuarios/editar/(:num)', 'Usuarios::editar/$1');
$routes->post('/usuarios/actualizar', 'Usuarios::actualizar');
$routes->get('/usuarios/eliminar/(:num)', 'Usuarios::eliminar/$1');
$routes->get('/usuarios/reingresar/(:num)', 'Usuarios::reingresar/$1');
$routes->post('/usuarios/valida', 'Usuarios::valida');
$routes->get('/usuarios/logout', 'Usuarios::logout');
$routes->get('/usuarios/cambia_password', 'Usuarios::cambia_password');
$routes->post('/usuarios/actualizar_password', 'Usuarios::actualizar_password');
$routes->post('/usuarios/authAPI', 'Usuarios::authAPI');


//Compras
$routes->get('/compras/nuevo', 'Compras::nuevo');
$routes->post('/compras/guardar', 'Compras::guardar');
$routes->get('/compras/muestraCompraPdf/(:num)', 'Compras::muestraCompraPdf/$1');
$routes->get('/compras/generaCompraPdf/(:num)', 'Compras::generaCompraPdf/$1');
$routes->get('/compras', 'Compras::index');
$routes->get('/compras/eliminar/(:num)', 'Compras::eliminar/$1');
$routes->get('/compras/eliminados', 'Compras::eliminados');
$routes->get('/compras/reingresar/(:num)', 'Compras::reingresar/$1');



//Temporal Movimientos
$routes->get('/temporalmovimiento/insertar/(:num)/(:any)/(:any)', 'TemporalMovimiento::insertar/$1/$2/$3');
$routes->get('/temporalmovimiento/cargaProductos/(:num)', 'TemporalMovimiento::cargaProductos/$1');
$routes->get('/temporalmovimiento/eliminar/(:num)/(:any)', 'TemporalMovimiento::eliminar/$1/$2');

//Ventas
$routes->get('/ventas/venta', 'Ventas::venta');
$routes->post('/ventas/guardar', 'Ventas::guardar');
$routes->get('/ventas/muestraTicket/(:num)', 'Ventas::muestraTicket/$1');
$routes->get('/ventas/generaTicket/(:num)', 'Ventas::generaTicket/$1');
$routes->get('/ventas', 'Ventas::index');
$routes->get('/ventas/eliminar/(:num)', 'Ventas::eliminar/$1');
$routes->get('/ventas/eliminados', 'Ventas::eliminados');
$routes->get('/ventas/reingresar/(:num)', 'Ventas::reingresar/$1');


//Cajas
$routes->get('/cajas', 'Cajas::index');
$routes->get('/cajas/eliminados', 'Cajas::eliminados');
$routes->get('/cajas/nuevo', 'Cajas::nuevo');
$routes->post('/cajas/insertar', 'Cajas::insertar');
$routes->get('/cajas/editar/(:num)', 'Cajas::editar/$1');
$routes->post('/cajas/actualizar', 'Cajas::actualizar');
$routes->get('/cajas/eliminar/(:num)', 'Cajas::eliminar/$1');
$routes->get('/cajas/reingresar/(:num)', 'Cajas::reingresar/$1');
$routes->get('/cajas/arqueos/(:num)', 'Cajas::arqueos/$1');
$routes->get('/cajas/nuevo_arqueo', 'Cajas::nuevo_arqueo');
$routes->post('/cajas/nuevo_arqueo', 'Cajas::nuevo_arqueo');
$routes->get('/cajas/cerrar', 'Cajas::cerrar');
$routes->post('/cajas/cerrar', 'Cajas::cerrar');




//Roles
$routes->get('/roles', 'Roles::index');
$routes->get('/roles/eliminados', 'Roles::eliminados');
$routes->get('/roles/nuevo', 'Roles::nuevo');
$routes->post('/roles/insertar', 'Roles::insertar');
$routes->get('/roles/editar/(:num)', 'Roles::editar/$1');
$routes->post('/roles/actualizar', 'Roles::actualizar');
$routes->get('/roles/eliminar/(:num)', 'Roles::eliminar/$1');
$routes->get('/roles/reingresar/(:num)', 'Roles::reingresar/$1');
$routes->get('/roles/permisos/(:num)', 'Roles::permisos/$1');
$routes->post('/roles/guardaPermisos', 'Roles::guardaPermisos');
$routes->get('/roles/no_autorizado', 'Roles::no_autorizado');


//API
$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes){
    $routes->get('clientes', 'Clientes::index');
    $routes->get('clientes/show/(:num)', 'Clientes::show/$1');
});

