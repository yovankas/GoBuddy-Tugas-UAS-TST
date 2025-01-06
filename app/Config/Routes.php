<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Home::index');
$routes->GET('signin', 'SigninController::index');
$routes->POST('SigninController/loginAuth', 'SigninController::loginAuth');
$routes->GET('signup', 'SignupController::index');
$routes->POST('SignupController/store', 'SignupController::store');
$routes->GET('logout', 'SigninController::logout');

// Authenticated routes
$routes->group('', ['filter' => 'authGuard'], function($routes) {
    $routes->GET('dashboard', 'Dashboard::index');

    $routes->GET('plans', 'TravelController::getPlans');
    $routes->POST('plans', 'TravelController::createPlan');
    $routes->GET('plans/view/(:num)', 'TravelController::getPlan/$1');
    $routes->post('plans/(:num)/confirmations', 'TravelController::addConfirmation/$1');
});

// Scraping Routes
$routes->get('flights', 'FlightsController::scrape');
$routes->get('flights/search', 'FlightsController::search');
$routes->get('hotels', 'HotelsController::scrape');
$routes->get('hotels/search', 'HotelsController::search');