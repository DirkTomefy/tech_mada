
<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/',              'Home::index');
$routes->get('login',           'UserController::loginPage');
$routes->post('login',          'UserController::login');
$routes->get('logout',          'UserController::logout');

// Employees - Creation only
$routes->get('employes/create',           'EmployeeController::create');
$routes->post('employes/save',            'EmployeeController::store');