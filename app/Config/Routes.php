
<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('employes',                   'EmployeeController::index');

$routes->match(['get', 'post'], 'employee/login',           'EmployeeController::login');
$routes->match(['get', 'post'], 'employee/loginProcess',    'EmployeeController::loginProcess');
$routes->get('employee/logout',          'EmployeeController::logout');
$routes->get('employee/dashboard',       'EmployeeController::dashboard');

// Employees - Creation only
$routes->get('employes/create',           'EmployeeController::create');

$routes->post('employes/save',            'EmployeeController::store');

// Congés - Employee
$routes->get('employee/conges/formulaire',       'CongeController::formulaire');
$routes->post('employee/conges/soumettre',       'CongeController::soumettre');
$routes->get('employee/conges/mes-demandes',    'CongeController::mesDemandes');

// Congés - RH/Admin
$routes->get('rh/conges/en-attente',             'CongeController::demandesEnAttente');
$routes->post('rh/conges/approuver/(:num)',      'CongeController::approuver/$1');
$routes->post('rh/conges/refuser/(:num)',        'CongeController::refuser/$1');