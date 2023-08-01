<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Pages');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::index');
$routes->get('sponsor/(:any)', 'Sponsor::$1');
$routes->get('sponsor', 'Sponsor');
$routes->get('akademi/(:any)', 'Akademi::$1');
$routes->get('akademi', 'Akademi');
$routes->get('tim/(:any)', 'Tim::$1');
$routes->get('tim', 'Tim');
$routes->get('galeri/(:any)', 'Galeri::$1');
$routes->get('galeri', 'Galeri');
$routes->get('pertandingan/(:any)', 'Pertandingan::$1');
$routes->get('pertandingan', 'Pertandingan');
$routes->get('berita/(:any)', 'Berita::$1');
$routes->get('berita', 'Berita');
$routes->get('register/(:any)', 'Register::$1');
$routes->get('register', 'Register');
$routes->get('login/(:any)', 'Login::$1');
$routes->get('login', 'Login');
$routes->get('(:any)', 'Pages::$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
