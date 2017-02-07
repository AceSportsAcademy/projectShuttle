<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/* Require the controller class
 **
*/
//***  require '../App/Controllers/Posts.php';

//***  require '../Core/Router.php';

/**
* Autoloader
*
*/

spl_autoload_register(function($class)
{
	# code...
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class). '.php';

	if(is_readable($file)) {
		require $root . '/' . str_replace('\\', '/', $class). '.php';
	}
});

/**
 * Routing
 */

$router = new Core\Router();

// Add the routes
$router->add('',array('controller'=> 'Home', 'action'=> 'index'));
$router->add('posts' , array('controller'=> 'Posts', 'action'=>'index'));
//$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');


/*    
// Display the routing table
echo '<pre>';
//var_dump($router->getRoutes());
echo htmlspecialchars(print_r($router->getRoutes(), true));
echo '</pre>';


// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for URL '$url'";
}

*/

/*
$router->add('',array('controller'=> 'Home', 'action'=> 'index'));
$router->add('posts' , array('controller'=> 'Posts', 'action'=>'index'));
$router->add('posts/new',array('controller'=>'Posts', 'action'=>'new'));
*/

$router->dispatch($_SERVER['QUERY_STRING']);

?>