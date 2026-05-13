
<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/',              'Home::index');
$routes->get('login',           'UserController::loginPage');
$routes->post('login',          'UserController::login');
$routes->get('logout',          'UserController::logout');

<<<<<<< HEAD
// Employees — page unique (formulaire + liste)
$routes->get('employes',                   'EmployeeController::index');
=======
// Employee Login
$routes->match(['get', 'post'], 'employee/login',           'EmployeeController::login');
$routes->match(['get', 'post'], 'employee/loginProcess',    'EmployeeController::loginProcess');
$routes->get('employee/logout',          'EmployeeController::logout');

// Employees - Creation only
$routes->get('employes/create',           'EmployeeController::create');
>>>>>>> login
$routes->post('employes/save',            'EmployeeController::store');