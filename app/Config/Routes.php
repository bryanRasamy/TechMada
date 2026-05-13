<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');
$routes->get('logout', 'GestionUser::deconnexion');



$routes->group('employe', ['filter' => 'auth'], function($routes) {
    $routes->get('MesDemandes', 'GestionEmploye::mesDemandes');
    $routes->get('dashboard', 'GestionEmploye::dashboard');
});

$routes->group('rh', ['filter' => 'rh'], function($routes) {
    
});

$routes->group('admin', ['filter' => 'admin'], function($routes) {
    
});
