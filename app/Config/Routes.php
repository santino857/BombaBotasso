<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing & Public Interactions
$routes->get('/', 'Home::index');
$routes->post('comentarios/guardar', 'Home::saveComment');
$routes->post('consultas/guardar', 'Home::saveInquiry');
$routes->post('pedidos/guardar', 'Home::saveOrder');

// Authentication
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::processRegister');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');

// Client Portal (Protected by AuthFilter)
$routes->get('mis-pedidos', 'Orders::myOrders', ['filter' => 'auth']);
$routes->get('mis-pedidos/detalle/(:num)', 'Orders::orderDetails/$1', ['filter' => 'auth']);

// Admin Panel (Protected by AdminFilter)
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin::index');

    // Products CRUD
    $routes->post('productos/crear', 'Admin::createProduct');
    $routes->post('productos/editar/(:num)', 'Admin::updateProduct/$1');
    $routes->get('productos/eliminar/(:num)', 'Admin::deleteProduct/$1');
    $routes->get('productos/toggle/(:num)', 'Admin::toggleProduct/$1');

    // Comments Moderation
    $routes->get('comentarios/eliminar/(:num)', 'Admin::deleteComment/$1');
    $routes->get('comentarios/toggle/(:num)', 'Admin::toggleComment/$1');

    // Inquiries
    $routes->get('consultas/marcar/(:num)', 'Admin::markInquiry/$1');
    $routes->get('consultas/eliminar/(:num)', 'Admin::deleteInquiry/$1');

    // Orders
    $routes->post('pedidos/estado/(:num)', 'Admin::updateOrderStatus/$1');
    $routes->get('pedidos/eliminar/(:num)', 'Admin::deleteOrder/$1');

    // Users
    $routes->post('usuarios/cambiar-rol/(:num)', 'Admin::changeUserRole/$1');
});