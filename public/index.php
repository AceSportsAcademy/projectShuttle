<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */


/***
*
* Twig
*/
require_once dirname(__DIR__) . '/vendor/autoload.php';
Twig_Autoloader::register();


/**
 * Autoloader
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});


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
