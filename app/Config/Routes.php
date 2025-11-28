<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//CONFIFURATIONS
$routes->get('configuration', 'Users::loadConfiguration');
$routes->post('configuration/save', 'Users::saveConfiguration');

//BOOKINGS
$routes->get('bookings', 'Bookings::index');
$routes->get('bookings/create/(:num)', 'Bookings::create/$1');
$routes->get('bookings/update/(:num)/(:alpha)', 'Bookings::updateStatus/$1/$2');


$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');

$routes->post('passenger/store', 'Users::storePassenger');
$routes->post('driver/store', 'Users::storeDriver');

$routes->post('auth/store', 'AuthController::authenticate');
$routes->get('auth/registerPassenger', 'AuthController::registerPassenger');
$routes->get('auth/registerDriver', 'AuthController::registerDriver');

$routes->get('/driver/bookings', 'Driver::bookings');
$routes->get('/passenger/searchRides', 'Passenger::searchRides');
$routes->get('/allUsers', 'Admin::loadAllUsers');
