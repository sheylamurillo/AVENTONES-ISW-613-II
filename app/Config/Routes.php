<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->get('configuration', 'Users::loadConfiguration');
$routes->post('configuration/save', 'Users::saveConfiguration');