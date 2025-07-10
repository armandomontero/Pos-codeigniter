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
