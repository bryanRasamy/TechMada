<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'GestionUser::index');
$routes->post('login/authentifier', 'GestionUser::authentifier');
$routes->get('logout', 'GestionUser::deconnexion');



$routes->group('employe', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'GestionEmploye::dashboard');
    $routes->get('mes-demandes', 'GestionEmploye::mesDemandes');
    $routes->get('calendrier', 'GestionEmploye::calendrier');
    $routes->get('nouvelle-demande', 'GestionEmploye::formulaireCongé');
    $routes->post('nouvelle-demande', 'GestionEmploye::soumettreConge');
    $routes->get('profil', 'GestionEmploye::profil');
});

$routes->group('rh', ['filter' => 'rh'], function($routes) {
    
});

$routes->group('admin', ['filter' => 'admin'], function($routes) {
    
});
