<?php
// File: app/Config/Routes.php (Add these routes)
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Auth::index');

// Auth routes
$routes->group('auth', function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
});

// Dashboard
$routes->get('dashboard', 'Dashboard::index');

// Items routes
$routes->group('items', function ($routes) {
    $routes->get('/', 'Items::index');
    $routes->get('create', 'Items::create');
    $routes->post('store', 'Items::store');
    $routes->get('show/(:num)', 'Items::show/$1');
    $routes->get('edit/(:num)', 'Items::edit/$1');
    $routes->post('update/(:num)', 'Items::update/$1');
    $routes->get('delete/(:num)', 'Items::delete/$1');
});

// Categories routes
$routes->group('categories', function ($routes) {
    $routes->get('/', 'Categories::index');
    $routes->get('create', 'Categories::create');
    $routes->post('store', 'Categories::store');
    $routes->get('edit/(:num)', 'Categories::edit/$1');
    $routes->post('update/(:num)', 'Categories::update/$1');
    $routes->get('delete/(:num)', 'Categories::delete/$1');
});

// Users routes
$routes->group('users', function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('create', 'Users::create');
    $routes->post('store', 'Users::store');
    $routes->get('edit/(:num)', 'Users::edit/$1');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->get('delete/(:num)', 'Users::delete/$1');
});

// Requests routes
$routes->group('requests', function ($routes) {
    $routes->get('/', 'Requests::index');
    $routes->get('create', 'Requests::create');
    $routes->post('store', 'Requests::store');
    $routes->get('show/(:num)', 'Requests::show/$1');
    $routes->post('approve/(:num)', 'Requests::approve/$1');
    $routes->post('reject/(:num)', 'Requests::reject/$1');
    $routes->get('delete/(:num)', 'Requests::delete/$1');
});

// Loans routes
$routes->group('loans', function ($routes) {
    $routes->get('/', 'Loans::index');
    $routes->get('create/(:num)', 'Loans::create/$1');
    $routes->get('create', 'Loans::create');
    $routes->post('store', 'Loans::store');
    $routes->get('show/(:num)', 'Loans::show/$1');
    $routes->post('return/(:num)', 'Loans::return/$1');
    $routes->get('delete/(:num)', 'Loans::delete/$1');
});

// Reports routes
$routes->group('reports', function ($routes) {
    $routes->get('/', 'Reports::index');
    $routes->get('items', 'Reports::items');
    $routes->get('requests', 'Reports::requests');
    $routes->get('loans', 'Reports::loans');
    $routes->get('users', 'Reports::users');
    $routes->get('export/(:alpha)', 'Reports::export/$1');
});
