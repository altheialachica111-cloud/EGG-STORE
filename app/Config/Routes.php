<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->group('admin', ['filter' => 'session'], function($routes) {
    $routes->get('stock-intake', 'Admin::stockIntake');
    $routes->post('add-stock', 'Admin::addStock');
    $routes->get('inventory', 'Admin::inventory');
    $routes->post('log-waste', 'Admin::logWaste');
    
    // Orders
    $routes->get('orders', 'Admin::orders');
    $routes->post('update-order-status', 'Admin::updateOrderStatus');
    
    // User Management
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');
});
