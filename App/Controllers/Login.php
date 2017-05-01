<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the login page
     *
     * @return void
     */
    public function newAction()
    {
    	View::renderTemplate('Login/new.html');
        
    }

    /**
     * Log a user in 
     *
     * @return void
     */
    public function createAction()
    {
    	$user = User::authenticate($_POST['email'], $_POST['password']);

        $remember_me = isset($_POST['remember_me']);

    	if($user){

            Auth::login($user, $remember_me);

            Flash::addMessage('Login successful', Flash::SUCCESS);

    		$this->redirect(Auth::getReturnToPage());

    	} else {

            Flash::addMessage('Login unsuccessful! Please try again', Flash::WARNING);

    		View::renderTemplate('Login/new.html', [
                'email' => $_POST['email'] , 
                'remember_me' => $remember_me
    			]);
    	}
    }

    /**
     * Log user out 
     *
     * @return void
     */
    public function destroyAction()
    {
    	// Destroy a session
        Auth::logout();

        $this->redirect('/login/show-logout-message');   
    }

    /**
     * Show logout successful message to the user 
     *
     * @return void
     */
    public function showLogoutMessageAction()
    {

        Flash::addMessage('Logout successful');

        $this->redirect('/');   
    }

}
