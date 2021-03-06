<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Profile controller
 *
 * PHP version 7.0
 */
class Profile extends Authenticated
{
	/**
     * Show the profile
     *
     * @return void
     */
	public function showAction()
	{
		View::renderTemplate('/Profile/show.html', [ 

			'user' => Auth::getUser()

			]);
	}

	/**
     * Edit profile
     *
     * @return void
     */
	public function editAction()
	{
		View::renderTemplate('Profile/edit.html', [

			'user' => Auth::getUser()

			]);
	}
}