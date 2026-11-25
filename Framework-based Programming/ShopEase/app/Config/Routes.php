<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('products', 'ProductController::index');
$routes->get('products/(:segment)', 'ProductController::show/$1');
$routes->get('cart', 'CartController::index');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('logout', 'AuthController::logout');

$routes->group('admin', function ($routes) {
    $routes->get('/', 'AdminController::index');
});
