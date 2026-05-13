
<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Admin dashboard
$routes->get('admin', 'AdminController::index');
$routes->post('admin/solde/save', 'AdminController::saveSolde');

// Employees — routes admin
$routes->get('admin/employes',                    'EmployeeController::index');
$routes->get('admin/employes/create',             'EmployeeController::create');
$routes->get('admin/employes/(:num)',             'EmployeeController::show/$1');
$routes->get('admin/employes/edit/(:num)',        'EmployeeController::edit/$1');
$routes->post('admin/employes/update/(:num)',     'EmployeeController::update/$1');
$routes->get('admin/employes/delete/(:num)',      'EmployeeController::delete/$1');

// Departements — routes admin
$routes->get('admin/departement',                  'DepartementController::index');
$routes->get('admin/departements',                 'DepartementController::index');
$routes->post('admin/departements/save',           'DepartementController::store');
$routes->get('admin/departements/edit/(:num)',     'DepartementController::edit/$1');
$routes->post('admin/departements/update/(:num)',  'DepartementController::update/$1');
$routes->get('admin/departements/delete/(:num)',   'DepartementController::delete/$1');

// RH validation des congés
$routes->get('rh', 'RhController::index');
$routes->post('rh/conges/approve/(:num)', 'RhController::approve/$1');
$routes->post('rh/conges/refuse/(:num)', 'RhController::refuse/$1');

$routes->match(['get', 'post'], 'employee/login',           'EmployeeController::login');
$routes->match(['get', 'post'], 'employee/loginProcess',    'EmployeeController::loginProcess');
$routes->get('employee/logout',          'EmployeeController::logout');

// Employees - Creation only
$routes->get('employes/create',           'EmployeeController::create');

$routes->post('employes/save',            'EmployeeController::store');
