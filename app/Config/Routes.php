
<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('employes',                   'EmployeeController::index');

$routes->match(['get', 'post'], 'employee/login',           'EmployeeController::login');
$routes->match(['get', 'post'], 'employee/loginProcess',    'EmployeeController::loginProcess');
$routes->get('employee/logout',          'EmployeeController::logout');

// Employees - Creation only
$routes->get('employes/create',           'EmployeeController::create');

$routes->post('employes/save',            'EmployeeController::store');