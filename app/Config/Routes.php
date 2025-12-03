<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


//ACTIVATE AACCOUNT
$routes->get('activate/(:any)', 'Users::activate/$1');

//SEARCH REPORT
$routes->get('admin/searchReport', 'Rides::loadSearchReportByDate');
$routes->post('admin/searchReport', 'Rides::loadSearchReportByDate');


//CONFIFURATIONS
$routes->get('configuration', 'Users::loadConfiguration');
$routes->post('configuration/save', 'Users::saveConfiguration');

//BOOKINGS
$routes->get('bookings', 'Bookings::index');
$routes->get('bookings/create/(:num)', 'Bookings::create/$1');
$routes->get('bookings/update/(:num)/(:alpha)', 'Bookings::updateStatus/$1/$2');

//SEARCH RIDES
$routes->get('searchRides', 'Rides::searchRidesPrivate');
$routes->post('searchRides', 'Rides::searchRidesPrivate');

$routes->get('searchRides/public', 'Rides::searchRidesPublic');
$routes->post('searchRides/public', 'Rides::searchRidesPublic');
$routes->get('passenger/searchRides', 'Rides::searchRidesPrivate');
$routes->post('passenger/searchRides', 'Rides::searchRidesPrivate');


//SEARCH REPORT
$routes->get('users/administrator/searchReport', 'Rides::loadSearchReportByDate');
$routes->post('users/administrator/searchReport', 'Rides::loadSearchReportByDate');

//LOGIN
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');

//SAVE USERS
$routes->post('passenger/store', 'Users::storePassenger');
$routes->post('driver/store', 'Users::storeDriver');

//Redireccionamientos a registros de pasajeros y drivers.
$routes->post('auth/store', 'AuthController::authenticate');
$routes->get('auth/registerPassenger', 'AuthController::registerPassenger');
$routes->get('auth/registerDriver', 'AuthController::registerDriver');

$routes->get('/driver/bookings', 'Driver::bookings');
$routes->get('/passenger/searchRides', 'Passenger::searchRides');
$routes->get('/allUsers', 'Admin::loadAllUsers');

//VEHICLES
$routes->get('vehicles', 'Vehicles::loadAllVehiclesfromUserLogged');
$routes->get('vehicles/newVehicle', 'Vehicles::newVehicle');
$routes->post('vehicles/store', 'Vehicles::storeVehicle');
$routes->get('vehicles/edit/(:num)', 'Vehicles::editVehicle/$1');
$routes->post('vehicles/update/(:num)', 'Vehicles::updateVehicle/$1');
$routes->get('vehicles/inactivate/(:num)', 'Vehicles::inactivateVehicle/$1');


