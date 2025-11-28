<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//CONFIGURATION
$routes->get('configuration', 'Users::loadConfiguration');
$routes->post('/configuration/save', 'Users::saveConfiguration');
