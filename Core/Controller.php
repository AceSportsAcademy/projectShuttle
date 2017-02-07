<?php

namespace Core;

/***
 * Base controller
 * 
 * PHP version 5.4
 */
abstract class Controller
{

	/***
	* Parameters from the matched route
	* @var array
	*/
	protected $route_params = array();

	/***
	* Class contructor
	* 
	* @param array $route_params Parameters from the route
	*
	* @return void
	*/

	public function __contruct($route_params)
	{
		$this->route_params = $route_params;

	}
}