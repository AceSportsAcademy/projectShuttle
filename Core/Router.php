<?php


/**
**
* Namespace
**/

namespace Core;
/**
* Router
*
*/
class Router {

	/*
	* Associative array of routes (the routing table)
	* @var array
	*/

	protected $routes = array();
	
	/*
	* Add a route to the routing table
	* @param string $route - the route URL
	* @param array $params Parameters (controller, action, etc)
	*
	* @return void
	*/	

	public function add($route, $params = array())
	{
		// Convert the route to a regular expression; escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);
		
		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

		// Convert variables with custom regular expressions
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

		// Add start and end delimiters, and case insensitive flag
		$route = '/^' . $route . '$/i';

		$this->routes[$route] = $params;
	}

	/****
	* Get all the routes from the routing table
	* 
	* @return array
	*/

	public function getRoutes()
	{
		return $this->routes;
	}

	public function match($url)
	{
		// Match to the fixed URL format /controller/action
		// $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";

		foreach ($this->routes as $route => $params) {
			# code...
			if (preg_match($route, $url, $matches)){
				//get named capture group values
				//$params = [];

				foreach ($matches as $key => $match) {
					# code...
					if (is_string($key)){
						$params[$key] = $match;
					}
				}

				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	 /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

     /***
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url)
    {

        $url = $this->removeQueryStringVariable($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\Controllers\\$controller";

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable(array($controller_object, $action))) {
                    $controller_object->$action();

                } else {
                    echo "Method $action (in controller $controller) not found";
                }
            } else {
                echo "Controller class $controller not found";
            }
        } else {
            echo 'No route matched.';
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /****
    * A URL of the format localhost/?page (one variable name, no value) won't
    * work however. (NB. The .htaccess file converts the first ? to a & when
    * it's passed through to the $_SERVER variable).
    *
    *@param string $url  The full URL
    *
    *@return sting the URL with query string variable removed
    ****/

    protected function removeQueryStringVariable($url)
    {
        if($url != ''){
            $parts = explode('&', $url, 2);

            if (strpos($parts[0],'=')=== false) {
                # code...
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

}


?>