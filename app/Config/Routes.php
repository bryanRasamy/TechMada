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
    $routes->get('nouvelle-demande', 'GestionEmploye::formulaireConge');
    $routes->post('nouvelle-demande/ajout', 'GestionEmploye::soumettreConge');
    $routes->get('profil', 'GestionEmploye::profil');
});

$routes->group('rh', ['filter' => 'role:rh,admin'], function($routes) {
    
});

$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('employes', 'GestionAdmin::employes');
    $routes->post('employes/ajouter', 'GestionAdmin::ajouterEmploye');

    $routes->get('departements', 'GestionAdmin::departements');
    $routes->post('departements/ajouter', 'GestionAdmin::ajouterDepartement');

    $routes->get('types-conge', 'GestionAdmin::typesConges');
    $routes->post('types-conge/ajouter', 'GestionAdmin::ajouterTypeConge');
});

// route dashboard admin
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('dashboard', 'GestionAdmin::dashboard');
});
