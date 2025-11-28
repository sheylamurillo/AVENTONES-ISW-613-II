<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');

$routes->post('passenger/store', 'Users::storePassenger');
$routes->post('driver/store', 'Users::storeDriver');

$routes->post('auth/store', 'AuthController::authenticate');
$routes->get('auth/registerPassenger', 'AuthController::registerPassenger');
$routes->get('auth/registerDriver', 'AuthController::registerDriver');

$routes->get('/driver/bookings', 'Driver::bookings');
$routes->get('/passenger/searchRides', 'Passenger::searchRides');
$routes->get('/allUsers', 'Admin::loadAllUsers');


