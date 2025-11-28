<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');


//BOOKINGS
$routes->get('bookings', 'Bookings::index');
$routes->get('/bookings/create/(:num)', 'Bookings::create/$1');
$routes->get('/bookings/update/(:num)/(:alpha)', 'Bookings::updateStatus/$1/$2');




