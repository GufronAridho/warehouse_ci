<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->get('test-shield', 'TestShield::index');
$routes->get('test-shield/manage', 'TestShield::manageUsers', ['filter' => 'group:admin']);  // Admin only
$routes->match(['GET', 'POST'], 'test-shield/edit/(:num)', 'TestShield::editUser/$1', ['filter' => 'group:admin']);
$routes->get('test-shield/delete/(:num)', 'TestShield::deleteUser/$1', ['filter' => 'group:admin']);
$routes->post('test-shield/logout', 'TestShield::logout');
$routes->get('user_info/(:any)', 'UserInfo::$1');

$routes->get('/', function () {
    if (! auth()->loggedIn()) {
        return redirect()->to('/login');
    }
    return redirect()->to('/home/index');
});

$routes->get('home/(:any)', 'Home::$1');
$routes->post('home/(:any)', 'Home::$1');
$routes->get('master_data/(:any)', 'Master_data::$1');
$routes->post('master_data/(:any)', 'Master_data::$1');
$routes->get('process/(:any)', 'Process::$1');
$routes->post('process/(:any)', 'Process::$1');
$routes->get('select_form/(:any)', 'Select_form::$1');
$routes->post('select_form/(:any)', 'Select_form::$1');
$routes->get('summary/(:any)', 'Summary::$1');
$routes->post('summary/(:any)', 'Summary::$1');
$routes->get('picking/(:any)', 'Picking::$1');
$routes->post('picking/(:any)', 'Picking::$1');
