<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/unidades', 'unidades::index');
$routes->get('/unidades/nuevo', 'unidades::nuevo');
$routes->post('/unidades/insertar', 'unidades::insertar');
