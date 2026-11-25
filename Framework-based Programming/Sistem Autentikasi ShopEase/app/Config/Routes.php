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

$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('masuk', 'AuthController::login');
    $routes->post('masuk', 'AuthController::attemptLogin');

    $routes->get('daftar', 'AuthController::register');
    $routes->post('daftar', 'AuthController::attemptRegister');

    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');

    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::attemptRegister');
});

$routes->post('keluar', 'AuthController::logout', [
    'filter' => 'auth',
]);

$routes->post('logout', 'AuthController::logout', [
    'filter' => 'auth',
]);

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('/', 'AdminController::index');
});
