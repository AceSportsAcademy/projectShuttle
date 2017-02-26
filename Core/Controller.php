<?php

namespace Core;

/**
 * Base controller
 *
<<<<<<< HEAD
 * PHP version 5.4
=======
 * PHP version 5.5.9
>>>>>>> f22ceed3f3cd1bcb475789310763efbd17dec766
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = array();

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
<<<<<<< HEAD

    /***
    ** Using __call magic method to execute check non-existent
    ** non-public methods 
    ** Methods before() and after() are used to accomplish
    ** this task
    **/

    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            # code...
            if ($this->before() !== false) {
                # code...
                call_user_func_array(array($this, $method), $args);
                $this->after();
                }
            } else {
                echo "Method $method not found in Controller". get_class($this);
            }
    }
               

    /**
        ** Before filter - called before an action method
        ** @return void
        **/
        protected function before()
        {

        }

        /**
        ** After filter - called after an action method
        ** @return void
        **/
        protected function after()
        {

        }
=======
>>>>>>> f22ceed3f3cd1bcb475789310763efbd17dec766
}
