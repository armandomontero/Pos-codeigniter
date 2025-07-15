<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //Home no logeado
$routes->get('/', 'Usuarios::login');

 //Home logeado
$routes->get('/index', 'Home::index');

//Unidades
$routes->get('/unidades', 'unidades::index');
$routes->get('/unidades/eliminados', 'unidades::eliminados');
$routes->get('/unidades/nuevo', 'unidades::nuevo');
$routes->post('/unidades/insertar', 'unidades::insertar');
$routes->get('/unidades/editar/(:num)', 'unidades::editar/$1');
$routes->post('/unidades/actualizar', 'unidades::actualizar');
$routes->get('/unidades/eliminar/(:num)', 'unidades::eliminar/$1');
$routes->get('/unidades/reingresar/(:num)', 'unidades::reingresar/$1');

//Categorias
$routes->get('/categorias', 'categorias::index');
$routes->get('/categorias/eliminados', 'categorias::eliminados');
$routes->get('/categorias/nuevo', 'categorias::nuevo');
$routes->post('/categorias/insertar', 'categorias::insertar');
$routes->get('/categorias/editar/(:num)', 'categorias::editar/$1');
$routes->post('/categorias/actualizar', 'categorias::actualizar');
$routes->get('/categorias/eliminar/(:num)', 'categorias::eliminar/$1');
$routes->get('/categorias/reingresar/(:num)', 'categorias::reingresar/$1');

//Productos
$routes->get('/productos', 'productos::index');
$routes->get('/productos/eliminados', 'productos::eliminados');
$routes->get('/productos/nuevo', 'productos::nuevo');
$routes->post('/productos/insertar', 'productos::insertar');
$routes->get('/productos/editar/(:num)', 'productos::editar/$1');
$routes->post('/productos/actualizar', 'productos::actualizar');
$routes->get('/productos/eliminar/(:num)', 'productos::eliminar/$1');
$routes->get('/productos/reingresar/(:num)', 'productos::reingresar/$1');
$routes->get('/productos/buscarPorCodigo/(:any)', 'productos::buscarPorCodigo/$1');


//Clientes
$routes->get('/clientes', 'clientes::index');
$routes->get('/clientes/eliminados', 'clientes::eliminados');
$routes->get('/clientes/nuevo', 'clientes::nuevo');
$routes->post('/clientes/insertar', 'clientes::insertar');
$routes->get('/clientes/editar/(:num)', 'clientes::editar/$1');
$routes->post('/clientes/actualizar', 'clientes::actualizar');
$routes->get('/clientes/eliminar/(:num)', 'clientes::eliminar/$1');
$routes->get('/clientes/reingresar/(:num)', 'clientes::reingresar/$1');


//Configuracion
$routes->get('/configuracion', 'configuracion::index');

//Usuarios
$routes->get('/usuarios', 'usuarios::index');
$routes->get('/usuarios/eliminados', 'usuarios::eliminados');
$routes->get('/usuarios/nuevo', 'usuarios::nuevo');
$routes->post('/usuarios/insertar', 'usuarios::insertar');
$routes->get('/usuarios/editar/(:num)', 'usuarios::editar/$1');
$routes->post('/usuarios/actualizar', 'usuarios::actualizar');
$routes->get('/usuarios/eliminar/(:num)', 'usuarios::eliminar/$1');
$routes->get('/usuarios/reingresar/(:num)', 'usuarios::reingresar/$1');
$routes->post('/usuarios/valida', 'usuarios::valida');
$routes->get('/usuarios/logout', 'usuarios::logout');
$routes->get('/usuarios/cambia_password', 'usuarios::cambia_password');
$routes->post('/usuarios/actualizar_password', 'usuarios::actualizar_password');

//Compras
$routes->get('/compras/nuevo', 'compras::nuevo');
$routes->post('/compras/guardar', 'compras::guardar');
$routes->get('/compras/muestraCompraPdf/(:num)', 'compras::muestraCompraPdf/$1');
$routes->get('/compras/generaCompraPdf/(:num)', 'compras::generaCompraPdf/$1');



//Temporal Compras
$routes->get('/temporalcompras/insertar/(:num)/(:num)/(:any)', 'temporalcompras::insertar/$1/$2/$3');
$routes->get('/temporalcompras/cargaProductos/(:num)', 'temporalcompras::cargaProductos/$1');
$routes->get('/temporalcompras/eliminar/(:num)/(:any)', 'temporalcompras::eliminar/$1/$2');



//Cajas
$routes->get('/cajas', 'cajas::index');
$routes->get('/cajas/eliminados', 'cajas::eliminados');
$routes->get('/cajas/nuevo', 'cajas::nuevo');
$routes->post('/cajas/insertar', 'cajas::insertar');
$routes->get('/cajas/editar/(:num)', 'cajas::editar/$1');
$routes->post('/cajas/actualizar', 'cajas::actualizar');
$routes->get('/cajas/eliminar/(:num)', 'cajas::eliminar/$1');
$routes->get('/cajas/reingresar/(:num)', 'cajas::reingresar/$1');

//Roles
$routes->get('/roles', 'roles::index');
$routes->get('/roles/eliminados', 'roles::eliminados');
$routes->get('/roles/nuevo', 'roles::nuevo');
$routes->post('/roles/insertar', 'roles::insertar');
$routes->get('/roles/editar/(:num)', 'roles::editar/$1');
$routes->post('/roles/actualizar', 'roles::actualizar');
$routes->get('/roles/eliminar/(:num)', 'roles::eliminar/$1');
$routes->get('/roles/reingresar/(:num)', 'roles::reingresar/$1');