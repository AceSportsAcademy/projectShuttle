<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Composer
 */
require '../vendor/autoload.php';


/**
 * Twig
 */
Twig_Autoloader::register();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', array('controller' => 'Home', 'action' => 'index'));
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', array('namespace' => 'Admin'));
    
$router->dispatch($_SERVER['QUERY_STRING']);
