<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Users::index');
$routes->get('/users', 'Users::index');
$routes->post('/users/create', 'Users::create');
$routes->get('/users/edit/(:segment)', 'Users::edit/$1');
$routes->post('/users/edit/(:segment)', 'Users::edit/$1');
$routes->get('/users/delete/(:segment)', 'Users::delete/$1');
$routes->post('/users/search', 'Users::search');
