<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('auth/register', 'AuthController::register');
$routes->post('auth/login', 'AuthController::login');

$routes->group('tasks', ['filter' => 'auth'], function($routes) {
    $routes->post('', 'TaskController::create');
    $routes->get('', 'TaskController::index');
    $routes->get('(:num)', 'TaskController::show/$1');
    $routes->put('(:num)', 'TaskController::update/$1');
    $routes->delete('(:num)', 'TaskController::delete/$1');
});

