<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //Home
$routes->get('/', 'Home::index');

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

//Clientes
$routes->get('/clientes', 'clientes::index');
$routes->get('/clientes/eliminados', 'clientes::eliminados');
$routes->get('/clientes/nuevo', 'clientes::nuevo');
$routes->post('/clientes/insertar', 'clientes::insertar');
$routes->get('/clientes/editar/(:num)', 'clientes::editar/$1');
$routes->post('/clientes/actualizar', 'clientes::actualizar');
$routes->get('/clientes/eliminar/(:num)', 'clientes::eliminar/$1');
$routes->get('/clientes/reingresar/(:num)', 'clientes::reingresar/$1');
