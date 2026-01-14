<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Auth routes
$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// User routes
$routes->get('user', 'User::index');
$routes->get('user/order', 'User::order');
$routes->post('user/place-order', 'User::placeOrder');
$routes->get('user/invoice/(:any)', 'User::invoice/$1');
$routes->get('user/my-orders', 'User::myOrders');

// Admin routes
$routes->get('admin', 'Admin::index');
$routes->get('admin/stock', 'Admin::stock');
$routes->get('admin/orders', 'Admin::orders');
$routes->get('admin/opname', 'Admin::opname');
$routes->post('admin/save-opname', 'Admin::saveOpname');
