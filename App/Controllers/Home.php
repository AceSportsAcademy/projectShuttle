<?php

namespace App\Controllers;

/**
* Home controller
*
* PHP version ***
*/

class Home extends \Core\Controller
{
	
	/****
	* Show the index page
	*
	* @return void
	**/
	public function index()
	{
		echo "Hello from the index action in the Home controller";
	}
}