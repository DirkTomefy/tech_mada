
<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/',              'Home::index');
$routes->get('login',           'UserController::loginPage');
$routes->post('login',          'UserController::login');
$routes->get('logout',          'UserController::logout');

// Employees — page unique (formulaire + liste)
$routes->get('employes',                   'EmployeeController::index');
$routes->post('employes/save',            'EmployeeController::store');
$routes->get('employes/(:num)',           'EmployeeController::show/$1');
$routes->get('employes/edit/(:num)',      'EmployeeController::edit/$1');
$routes->post('employes/update/(:num)',   'EmployeeController::update/$1');
$routes->get('employes/delete/(:num)',    'EmployeeController::delete/$1');

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