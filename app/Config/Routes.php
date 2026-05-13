
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