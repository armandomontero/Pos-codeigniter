<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 //Home
$routes->get('/', 'Home::index');

//Unidades
$routes->get('/unidades', 'unidades::index');
$routes->get('/unidades/nuevo', 'unidades::nuevo');
$routes->post('/unidades/insertar', 'unidades::insertar');
$routes->get('/unidades/editar/(:num)', 'unidades::editar/$1');
